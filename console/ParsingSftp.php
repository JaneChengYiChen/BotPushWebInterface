<?php
namespace App\SftpParsing;

use App\Objects\ControlUnit\Supplier\SupplierFileImportControlUnit;
use App\SupParsingLists;
use File;
use Illuminate\Http\Request;
use phpseclib\Net\SFTP;
use ZipArchive;

class SftpParsing
{
    public function __construct($range, $doc, $sup)
    {
        $this->range = $range;
        $this->doc = $doc;
        $this->sup = $sup;
        $this->yesterday = date('Ymd', strtotime('-1 days'));
        $this->file = [];
        $this->insertSupplierList = Connections::SUP_LIST;
        $this->dirToDel = Connections::SUP_LIST;

        if ($this->sup !== 'DefaultParsingAll') {
            $this->insertSupplierList = [$this->sup];
            $this->dirToDel = [$this->sup];
        }
    }

    /**
     * download files from SFTP
     */
    public function dailyParsing()
    {
        $sftpConnection = Connections::CONNECTION_SUP;

        switch ($this->sup) {
            case 'DefaultParsingAll':
                break;
            default:
                $sftpConnection = [Connections::CONNECTION_SUP[$this->sup]];
        }

        foreach ($sftpConnection as $key => $sftpConnection) {
            $this->sup = empty($key) ? (int)$this->sup : $key;//empty true:表示單一保險公司; false: 表示全連線
            $this->sftp = Connections::login($sftpConnection);
            $files = $this->sftp->nlist();
            $this->getDailyFile($files);
        }
    }

    /**
     * insert data from downloaded files
     */
    public function dailyInsert()
    {
        $request = new Request;
        $doc = $this->doc;
        foreach ($this->insertSupplierList as $supplierlist) {
            $file_path = storage_path("app/{$supplierlist}/*.txt");
            foreach (glob($file_path) as $file) {
                //特定文件
                if ($doc != 'DefaultAllDoc') {
                    $value = !str_contains($file, $doc);
                    if ($value) {
                        continue;
                    }
                }
                $Unit = new SupplierFileImportControlUnit;
                
                $Unit->insertFromArray(
                    [
                        $Unit::INPUT_FILE_FULL_NAME => $file,
                        $Unit::INPUT_INSERT_OR_NOT => true,
                    ]
                );
                $Unit->run();
            }
        }
    }

    /**
     * 歷史紀錄
     */
    private function historicalRecords()
    {
        $SupParsingLists = new SupParsingLists;
        
        $array = $SupParsingLists->where('supplier', $this->insertSupplierList)
        ->select('file_name')
        ->get()
        ->toArray();
        
        $lists = [];
        
        foreach ($array as $value) {
            $lists[] = $value['file_name'];
        }

        return $lists;
    }
    /**
     * documenting daily parsing records
     */
    public function documentDailyParsingRecords()
    {
        $SupParsingLists = new SupParsingLists;

        foreach ($this->file as $key => $file) {
            $this->file[$key]['created_at'] = new \DateTime();
            $this->file[$key]['updated_at'] = new \DateTime();
        }
        $part = (int) (2100 / 4) - 1;
        $insertList = array_chunk($this->file, $part);
        foreach ($insertList as $i) {
            $SupParsingLists->insert($i);
        }
    }

    public function cleanSupplierFile()
    {
        foreach ($this->dirToDel as $supplier) {
            File::deleteDirectory(storage_path("app/{$supplier}"));
        }
    }

    private function whichFiles()
    {
        switch ($this->sup) {
            case 'DefaultParsingAll':
                $files = $this->sftp->nlist();
                break;
            default:
                $files = [$this->sup];
                break;
        }
        return $files;
    }

    private function getDirFileList($files)
    {
        $ignoreList = ['.', '..'];
        foreach ($files as $files) {
            $list = !in_array($files, $ignoreList);
            if ($list) {
                $this->getDailyFile($this->getFileList($files), $files);
            }
        }
    }

    private function getFileList($files)
    {
        return $this->sftp->nlist("./{$files}");
    }

    private function getDailyFile($lists)
    {
        $records = $this->historicalRecords();
        $lists = array_diff($lists, $records);
        
        foreach ($lists as $lists) {
            if ($lists == '.' ||
                $lists == '..') {
                continue;
            }

            $this->parsingRange($lists);
        }
    }

    private function parsingRange($lists)
    {
        if ($this->range != 'all') {
            $value = str_contains($lists, $this->yesterday);
            if ($value == false) {
                return;
            }
        }

        $this->file[] = [
            'file_name' => (string) $lists,
            'supplier' => (int) $this->sup,
        ];

        $this->classifyFiles($lists);
    }

    private function classifyFiles($file)
    {
        $range = $this->range;
        $fileDir = storage_path("app/{$this->sup}");
        File::makeDirectory($fileDir, $mode = 0755, true, true);
        $localfilename = \str_replace('TXT', 'txt', $file);
        $filePath = $fileDir . "/$localfilename";
        $extractTo = $fileDir . '/';

        $this->sftp->get("{$file}", $filePath);

        //zip file
        $filename = strtolower($file);
        $zipFile = preg_match('(.zip)', $filename);
        switch ($zipFile) {
            case true:
                $this->unzipFileAndDownload($filePath, $extractTo);
                break;
            default:
                break;
        }
        //dir file
        $this->getDirFiles($file);
    }

    private function unzipFileAndDownload($filePath, $extractTo)
    {
        switch ($this->sup) {
            case 108:
                $key = env('unzip108key');
                $pwd = env('unzip108pwd');
                exec("openssl enc -d -aes-256-ecb -K {$key} -in {$filePath} -out {$filePath}.zip");
                exec("unzip -P {$pwd} {$filePath}.zip -d {$extractTo}");
                break;
            case 164:
                $pwd = env('unzip164pwd');
                $zip = new ZipArchive;
                $zip->open($filePath, ZipArchive::CREATE);
                $zip->setPassword($pwd);
                $zip->extractTo($extractTo);
                $zip->close();
                break;
            default:
                $zip = new ZipArchive;
                $zip->open($filePath, ZipArchive::CREATE);
                $zip->extractTo($extractTo);
                $zip->close();
                break;
        }
    }

    private function getDirFiles($name)
    {
        $n = preg_match("/^([0-9]+)$/", $name);
        $c = preg_match("/^([\x7f-\xff]+)$/", $name);
        if ($n || $c) {
            $dirname = $name . '_';
            $dir = storage_path("app/{$this->sup}/{$dirname}");
            File::makeDirectory($dir, $mode = 0755, true, true);

            $dirFiles = $this->getFileList($name);
            foreach ($dirFiles as $file) {
                if ($file == '.' ||
                    $file == '..') {
                    continue;
                }

                $localfilename = \str_replace('TXT', 'txt', $file);
                $filePath = $dir . "/$localfilename";
                $this->sftp->get("./{$name}/{$file}", $filePath);
            }
        }
    }
}
