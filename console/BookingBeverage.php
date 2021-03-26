<?php

use LINE\LINEBot;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\Constant\Flex\ComponentButtonStyle;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpaceSize;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpacerComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\Constant\ActionType;
use LINE\LINEBot\Constant\MessageType;

//-----------------------------------------------
//取log資料
$log = print_log();
$log->addInfo('hi');
   $log->addInfo($payload->events[0]->type);
   $log->addInfo($payload->events[0]->timestamp);
   $log->addInfo($payload->events[0]->source->type);

   $type = $payload->events[0]->type;

if ($type == 'postback') {
    $log->addInfo($payload->events[0]->postback->data);
}
if ($type == 'message') {
    $receive_text = $payload->events[0]->message->text;
    $log->addInfo($receive_text);
}
//------------------------------------------------
//對特定Line_ID傳送特定訊息

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$type=$_FILES['fileField']['type'];
$size=$_FILES['fileField']['size'];
$name=$_FILES['fileField']['name'];
$tmp_name=$_FILES['fileField']['tmp_name'];

$ID =  $_POST['Line_ID'][0];
$mes = $_POST['content'];
$img = $_POST['img'];
$img2 = $_ENV[''].$img;
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($mes);
$response = $bot->pushMessage($ID, $textMessageBuilder);

$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img2, $img2);
$response = $bot->pushMessage($ID, $ImageMessageBuilder);


$ID = '/Users/user/Documents/www/bot_practice/logs/ID.log';
$content = '/Users/user/Documents/www/bot_practice/logs/content.log';
$file_ID = file($ID);
$file_content = file($content);


if($type_text !='message'){
    $text = '想收信的話，請輸入單字「message」';
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
    $response = $bot->replyMessage($payload->events[0]->replyToken, $textMessageBuilder);
}

//------------------------------------------------
//calculation_number to English

//1922999999.99
//one billion,
//nine hundred and twenty two million,
//nine hundred and ninety nine thousand,
//nine hundred and ninety nine dollars and ninety nine cents
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$type_text = (integer)$payload->events[0]->message->text;
$type_text2 = $payload->events[0]->message->text;

$A= substr($type_text, -2.0); //十位數與個位數
$C= substr($type_text, -3, -2); //百位數
$E = substr($type_text, -5, -3); //十千與個各千數
$D = substr($type_text, -6, -5); //千千數
$F = substr($type_text, -8, -6); //十百萬與個百萬
$G = substr($type_text, -9, -8); //百百萬
$H = substr($type_text, -10, -9); //one billion
$I = substr(
    strrchr(
        $type_text2,
        '.'
    ),
    1
); //小數點

$number["0"] = "zero";
$number["1"] = "one";
$number["9"] = "nine";
$number["99"] = "ninety nine";
$number['22'] = 'twenty two';

foreach($number as $key => $value){
    if ($key == $A ) {$value1 = $value;} //十位數與百位數
    if ($key == $C){$value2 = $value;} //百位數
    if ($key == $E){$value4 = $value;} //十千與個各千數
    if ($key == $D){$value3 = $value;} //千千數
    if ($key == $F){$value5 = $value;} //十百萬與個百萬
    if ($key == $G){$value6 = $value;} //百百萬
    if ($key == $H){$value7 = $value;} //億萬位數
    if ($key == $I){$value8 = $value;} //小數點
}

$log->addInfo($I);

$text = $value7.' billion, '.
$value6.' hundred and '.$value5.' million, '.
$value3.' hundred and '.$value4.' thousand, '.
$value2.' hundred and '.$value1.' dollars'.' and '.$value8.' cents';

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
$response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);


$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$response = $bot->replyMessage(
    $_ENV['reply_token'],
    new ImagemapMessageBuilder(
        'https://i.imgur.com/qJ7NYNI.jpg',
        '你有一則新訊息',
        new BaseSizeBuilder(1040, 1040),
        [
            new ImagemapUriActionBuilder(
                'https://i.imgur.com/Do1jTEI.jpg',
                new AreaBuilder(0, 0, 1040, 520)
            ),

            new ImagemapMessageActionBuilder(
                'Fortune',
                new AreaBuilder(0, 520, 1040, 520)
            )
        ]
    )
);

//---------------------------------------------------
//點餐機器人
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$type = $payload->events[0]->type;
$drink_menu = array();
$drink_menu['紅茶拿鐵'] = 50;
$drink_menu['綠茶拿鐵'] = 60;

$count_data2 = '/Users/user/Documents/www/bot_practice/logs/milktea.log';
$count_data3 = '/Users/user/Documents/www/bot_practice/logs/greentea.log';
$file_milktea = file($count_data2);
$file_greentea = file($count_data3);

if($type == 'postback'){
    $data = $payload->events[0]->postback->data;

    //$log->addInfo($data);
    if($data == '紅茶拿鐵'){
        foreach($drink_menu as $key => $item){
            if($data==$key){
                $add=1;
                $initial= 0;
                $file_milktea = file($count_data2);
                $fp = fopen($count_data2,'w');
                $initial = $file_milktea[0]+$add;
                fwrite($fp,$initial);
                fclose($fp);
                $item_milktea = $item * $initial;
                $total = $item_milktea + $file_greentea[0]*60;

                if($file_greentea[0] !=0 ){
                $text_milktea = '目前'.$initial.'杯'.$key.'，'.$file_greentea[0].'杯綠茶拿鐵'.'共'.$total.'元';
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text_milktea);
                $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);

                }else{
                $text_milktea = '目前'.$initial.'杯'.$key.'共'.$item_milktea.'元';
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text_milktea);
                $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);
                }

             }
    }
    }

    if($data == '綠茶拿鐵'){
        foreach($drink_menu as $key => $item){
            if($data==$key){
                $add=1;
                $initial= 0;
                $file_greentea = file($count_data3);
                $fp = fopen($count_data3,'w');
                $initial = $file_greentea[0]+$add;
                fwrite($fp,$initial);
                fclose($fp);
                $item_greentea = $item * $initial;
                $total = $item_greentea + $file_milktea[0]*50;

                if($file_milktea[0] !=0 ){
                    $text_greentea = '目前'.$file_milktea[0].'杯紅茶拿鐵'.'，'.$initial.'杯'.$key.'共'.$total.'元';
                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text_greentea);
                    $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);

                }else{
                $text_greentea = '目前'.$initial.'杯'.$key.'共'.$item_greentea.'元';
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text_greentea);
                $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);

                }

            }
    }
    }

    if($data == '送出'){
        if($file_milktea[0] != 0 && $file_greentea[0] == 0){
            $num_milktea = $file_milktea[0];
            $total_num = $file_milktea[0] *50;
            $text = '好的，您總共點了'.$num_milktea.'杯紅茶拿鐵，共'.$total_num.'元，馬上為您準備，謝謝光臨！';
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);
            $fp1 = fopen($count_data2,'w');
            $fp2 = fopen($count_data3,'w');
            $cover1 = $file_milktea[0]-$file_milktea[0];
            $cover2 = $file_greentea[0]-$file_greentea[0];
            fwrite($fp1,$cover1);
            fwrite($fp2,$cover2);
            fclose($fp1);
            fclose($fp2);
            }

        if($file_milktea[0] == 0 && $file_greentea[0] != 0){
            $num_greentea = $file_greentea[0];
            $total_num = $file_greentea[0] *60;
            $text = '好的，您總共點了'.$num_greentea.'杯綠茶拿鐵，共'.$total_num.'元，馬上為您準備，謝謝光臨！';
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);
            $fp1 = fopen($count_data2,'w');
            $fp2 = fopen($count_data3,'w');
            $cover1 = $file_milktea[0]-$file_milktea[0];
            $cover2 = $file_greentea[0]-$file_greentea[0];
            fwrite($fp1,$cover1);
            fwrite($fp2,$cover2);
            fclose($fp1);
            fclose($fp2);
            }

        if ($file_milktea[0] != 0 && $file_greentea[0] != 0 ){
            $num_milktea = $file_milktea[0];
            $num_greentea = $file_milktea[0];
            $total_num = $file_milktea[0] *50 + $file_greentea[0] *60;
            $text = '好的，您總共點了'.$num_milktea[0].'杯紅茶拿鐵和'.$num_greentea.'杯綠茶拿鐵，共'.$total_num.'元，馬上為您準備，謝謝光臨！';
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);
            $fp1 = fopen($count_data2,'w');
            $fp2 = fopen($count_data3,'w');
            $cover1 = $file_milktea[0]-$file_milktea[0];
            $cover2 = $file_greentea[0]-$file_greentea[0];
            fwrite($fp1,$cover1);
            fwrite($fp2,$cover2);
            fclose($fp1);
            fclose($fp2);
        }
        else{
            $text = '親愛的，你還沒點餐喔，請輸入單字「menu」';
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);
        }

}

    if($data == '取消'){
        $file_milktea = file($count_data2);
        $file_greentea = file($count_data3);
        if ($file_milktea[0] != 0 || $file_greentea[0] != 0 ){
            $fp1 = fopen($count_data2,'w');
            $fp2 = fopen($count_data3,'w');
            $cover1 = $file_milktea[0]-$file_milktea[0];
            $cover2 = $file_greentea[0]-$file_greentea[0];
            fwrite($fp1,$cover1);
            fwrite($fp2,$cover2);
            fclose($fp1);
            fclose($fp2);
            $text = '好的，已為您取消全部的訂購項目';
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);

        } else {
            $text = '親愛的，你還沒點餐喔，請輸入單字「menu」';
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);

        }

    }

    }

$type_text = strtolower($payload->events[0]->message->text);

$menu = (FlexMessageBuilder::builder()
        ->setAltText('你有一則新訊息')
        ->setContents(
            BubbleContainerBuilder::builder()
                // ->setHeader(
                //     BoxComponentBuilder::builder()
                //     ->setLayout(ComponentLayout::HORIZONTAL)
                //     ->setContents([
                //         new TextComponentBuilder("Manu")
                //     ]))

                ->setHero(
                    ImageComponentBuilder::builder()
                    ->setUrl('https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png')
                    ->setSize(ComponentImageSize::FULL)
                    ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
                    ->setAspectMode(ComponentImageAspectMode::FIT)
                    ->setAction(new UriTemplateActionBuilder(null, 'https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png'))

                )

                ->setBody(
                    BoxComponentBuilder::builder()
                        ->setLayout(ComponentLayout::VERTICAL)
                        ->setSpacing(ComponentSpacing::SM)
                        ->setMargin(ComponentMargin::SM)
                        ->setContents(
                            array(
                            BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setSpacing(ComponentSpacing::SM)
                            ->setMargin(ComponentMargin::SM)
                            ->setContents([
                                new TextComponentBuilder("Jane's Drink Test")]),

                            BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setSpacing(ComponentSpacing::SM)
                            ->setMargin(ComponentMargin::SM)
                            ->setContents(
                                array(BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setContents(
                                    array(TextComponentBuilder::builder()
                                    ->setText('Tel')
                                    ->setColor('#aaaaaa')
                                    ->setSize('sm')
                                    ->setMargin(ComponentMargin::XS)
                                    ->setFlex(5)
                                    ->setAlign('center'),
                                    separatorComponentBuilder::builder(),
                                    TextComponentBuilder::builder()
                                    ->setText('XXX')
                                    ->setColor('#566270')
                                    ->setSize('sm')
                                    ->setMargin(ComponentMargin::SM)
                                    ->setFlex(5)
                                    ->setAlign('center')

                                    )

                                ),

                                BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setSpacing(ComponentSpacing::SM)
                                ->setMargin(ComponentMargin::SM)
                                ->setContents(
                                        array(TextComponentBuilder::builder()
                                        ->setText('Address')
                                        ->setColor('#aaaaaa')
                                        ->setSize('sm')
                                        ->setMargin(ComponentMargin::SM)
                                        ->setFlex(5)
                                        ->setAlign('center'),
                                        separatorComponentBuilder::builder(),
                                        TextComponentBuilder::builder()
                                        ->setText('Taipei')
                                        ->setColor('#566270')
                                        ->setSize('sm')
                                        ->setMargin(ComponentMargin::SM)
                                        ->setFlex(5)
                                        ->setAlign('center')

                                )))

                                ))))

                ->setFooter(
                    BoxComponentBuilder::builder()
                        ->setLayout(ComponentLayout::VERTICAL)
                        ->setSpacing(ComponentSpacing::SM)
                        ->setMargin(ComponentMargin::SM)
                        ->setContents(
                            array(
                                BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setSpacing(ComponentSpacing::SM)
                                ->setMargin(ComponentMargin::SM)
                                ->setContents(
                                    array(BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                        array(TextComponentBuilder::builder()
                                        ->setText('紅茶拿鐵')
                                        ->setColor('#264e70')
                                        ->setSize('lg')
                                        ->setAlign('center')
                                        ->setMargin(ComponentMargin::SM)
                                        ->setAction(new PostbackTemplateActionBuilder('紅茶拿鐵','紅茶拿鐵','紅茶拿鐵＋1'))
                                        ->setFlex(5))),

                                    separatorComponentBuilder::builder(),

                                    BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                            array(TextComponentBuilder::builder()
                                            ->setText('綠茶拿鐵')
                                            ->setColor('#b5525c')
                                            ->setSize('lg')
                                            ->setAlign('center')
                                            ->setMargin(ComponentMargin::SM)
                                            ->setAction(new PostbackTemplateActionBuilder('綠茶拿鐵','綠茶拿鐵','綠茶拿鐵＋1'))
                                            ->setFlex(5)))
                                )),
                                separatorComponentBuilder::builder(),

                                BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setSpacing(ComponentSpacing::SM)
                                ->setMargin(ComponentMargin::SM)
                                ->setContents(
                                    array(
                                        BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                            array(TextComponentBuilder::builder()
                                            ->setText('送出')
                                            ->setColor('#309286')
                                            ->setSize('lg')
                                            ->setAlign('center')
                                            ->setMargin(ComponentMargin::SM)
                                            ->setAction(new PostbackTemplateActionBuilder('送出','送出','我點好了'))
                                            ->setFlex(5))),

                                    separatorComponentBuilder::builder(),

                                    BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                            array(TextComponentBuilder::builder()
                                            ->setText('取消')
                                            ->setColor('#F16B6F')
                                            ->setSize('lg')
                                            ->setAlign('center')
                                            ->setMargin(ComponentMargin::SM)
                                            ->setAction(new PostbackTemplateActionBuilder('取消','取消','我想取消全部訂餐'))
                                            ->setFlex(5))))),

                                    separatorComponentBuilder::builder()

                                    )

                        )
                )));

if($type_text =='menu'){
    $fp1 = fopen($count_data2,'w');
    $fp2 = fopen($count_data3,'w');
    $cover1 = $file_milktea[0]-$file_milktea[0];
    $cover2 = $file_greentea[0]-$file_greentea[0];
    fwrite($fp1,$cover1);
    fwrite($fp2,$cover2);
    fclose($fp1);
    fclose($fp2);
    $response = $bot->replyMessage($payload->events[0]->replyToken, $menu);
     }
if($type_text !='menu'){
    $text = '想點餐的話，請輸入單字「menu」';
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
    $response = $bot->replyMessage($payload->events[0]->replyToken,$textMessageBuilder);
}

//------------------------------------------------
//Flex Template_你點了一杯紅茶拿鐵_MessageTemplate

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$type = $payload->events[0]->type;
$type_text = $payload->events[0]->message->text;
$log = print_log();
$log->addInfo($payload->events[0]->type);

$menu = (FlexMessageBuilder::builder()
        ->setAltText('你有一則新訊息')
        ->setContents(
            BubbleContainerBuilder::builder()
                // ->setHeader(
                //     BoxComponentBuilder::builder()
                //     ->setLayout(ComponentLayout::HORIZONTAL)
                //     ->setContents([
                //         new TextComponentBuilder("Manu")
                //     ]))

                ->setHero(
                    ImageComponentBuilder::builder()
                    ->setUrl('https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png')
                    ->setSize(ComponentImageSize::FULL)
                    ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
                    ->setAspectMode(ComponentImageAspectMode::FIT)
                    ->setAction(new UriTemplateActionBuilder(null, 'https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png'))

                )

                ->setBody(
                    BoxComponentBuilder::builder()
                        ->setLayout(ComponentLayout::VERTICAL)
                        ->setSpacing(ComponentSpacing::SM)
                        ->setMargin(ComponentMargin::SM)
                        ->setContents(
                            array(
                            BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setSpacing(ComponentSpacing::SM)
                            ->setMargin(ComponentMargin::SM)
                            ->setContents([
                                new TextComponentBuilder("Jane's Drink Test")]),

                            BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setSpacing(ComponentSpacing::SM)
                            ->setMargin(ComponentMargin::SM)
                            ->setContents(
                                array(BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setContents(
                                    array(TextComponentBuilder::builder()
                                    ->setText('Tel')
                                    ->setColor('#aaaaaa')
                                    ->setSize('sm')
                                    ->setMargin(ComponentMargin::XS)
                                    ->setFlex(5)
                                    ->setAlign('center'),
                                    separatorComponentBuilder::builder(),
                                    TextComponentBuilder::builder()
                                    ->setText('XXX')
                                    ->setColor('#566270')
                                    ->setSize('sm')
                                    ->setMargin(ComponentMargin::SM)
                                    ->setFlex(5)
                                    ->setAlign('center')

                                    )

                                ),

                                BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setSpacing(ComponentSpacing::SM)
                                ->setMargin(ComponentMargin::SM)
                                ->setContents(
                                        array(TextComponentBuilder::builder()
                                        ->setText('Address')
                                        ->setColor('#aaaaaa')
                                        ->setSize('sm')
                                        ->setMargin(ComponentMargin::SM)
                                        ->setFlex(5)
                                        ->setAlign('center'),
                                        separatorComponentBuilder::builder(),
                                        TextComponentBuilder::builder()
                                        ->setText('Taipei')
                                        ->setColor('#566270')
                                        ->setSize('sm')
                                        ->setMargin(ComponentMargin::SM)
                                        ->setFlex(5)
                                        ->setAlign('center')

                                )))

                                ))))

                ->setFooter(
                    BoxComponentBuilder::builder()
                        ->setLayout(ComponentLayout::VERTICAL)
                        ->setSpacing(ComponentSpacing::SM)
                        ->setMargin(ComponentMargin::SM)
                        ->setContents(
                            array(
                                BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setSpacing(ComponentSpacing::SM)
                                ->setMargin(ComponentMargin::SM)
                                ->setContents(
                                    array(BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                        array(TextComponentBuilder::builder()
                                        ->setText('紅茶拿鐵')
                                        ->setColor('#264e70')
                                        ->setSize('lg')
                                        ->setAlign('center')
                                        ->setMargin(ComponentMargin::SM)
                                        ->setAction(new MessageTemplateActionBuilder('紅茶拿鐵','你點了一杯紅茶拿鐵'))
                                        ->setFlex(5))),

                                    separatorComponentBuilder::builder(),

                                    BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                            array(TextComponentBuilder::builder()
                                            ->setText('綠茶拿鐵')
                                            ->setColor('#b5525c')
                                            ->setSize('lg')
                                            ->setAlign('center')
                                            ->setMargin(ComponentMargin::SM)
                                            ->setAction(new MessageTemplateActionBuilder('綠茶拿鐵','你點了一杯綠茶拿鐵'))
                                            ->setFlex(5)))
                                )),
                                separatorComponentBuilder::builder(),

                                BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::HORIZONTAL)
                                ->setSpacing(ComponentSpacing::SM)
                                ->setMargin(ComponentMargin::SM)
                                ->setContents(
                                    array(
                                        BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                            array(TextComponentBuilder::builder()
                                            ->setText('抹茶拿鐵')
                                            ->setColor('#309286')
                                            ->setSize('lg')
                                            ->setAlign('center')
                                            ->setMargin(ComponentMargin::SM)
                                            ->setAction(new MessageTemplateActionBuilder('抹茶拿鐵','你點了一杯抹茶拿鐵'))
                                            ->setFlex(5))),

                                    separatorComponentBuilder::builder(),

                                    BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                            array(TextComponentBuilder::builder()
                                            ->setText('紅豆拿鐵')
                                            ->setColor('#F16B6F')
                                            ->setSize('lg')
                                            ->setAlign('center')
                                            ->setMargin(ComponentMargin::SM)
                                            ->setAction(new MessageTemplateActionBuilder('Null','你點了一杯紅豆拿鐵'))
                                            ->setFlex(5))))),

                                    separatorComponentBuilder::builder(),

                                    BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::HORIZONTAL)
                                    ->setSpacing(ComponentSpacing::SM)
                                    ->setMargin(ComponentMargin::SM)
                                    ->setContents(
                                        array(
                                            BoxComponentBuilder::builder()
                                            ->setLayout(ComponentLayout::HORIZONTAL)
                                            ->setSpacing(ComponentSpacing::SM)
                                            ->setMargin(ComponentMargin::SM)
                                            ->setContents(
                                                array(TextComponentBuilder::builder()
                                                    ->setText('烏龍拿鐵')
                                                    ->setColor('#acdbdf')
                                                    ->setSize('lg')
                                                    ->setAlign('center')
                                                    ->setMargin(ComponentMargin::SM)
                                                    ->setAction(new MessageTemplateActionBuilder('Null','你點了一杯烏龍拿鐵'))
                                                    ->setFlex(5))),

                                            separatorComponentBuilder::builder(),

                                            BoxComponentBuilder::builder()
                                            ->setLayout(ComponentLayout::HORIZONTAL)
                                            ->setSpacing(ComponentSpacing::SM)
                                            ->setMargin(ComponentMargin::SM)
                                            ->setContents(
                                                array(TextComponentBuilder::builder()
                                                    ->setText('四季春拿鐵')
                                                    ->setColor('#f9989f')
                                                    ->setSize('lg')
                                                    ->setAlign('center')
                                                    ->setMargin(ComponentMargin::SM)
                                                    ->setAction(new MessageTemplateActionBuilder('Null','你點了一杯四季春拿鐵'))
                                                    ->setFlex(5)))))

                                    )

                        )
                )));

if($type_text =='menu'){
    $response = $bot->replyMessage($payload->events[0]->replyToken, $menu);
 }

//------------------------------------------------
//乘法計算機
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$textMessageBuilder1 = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('Hi 我是乘法小機器人，請輸入你想要相乘的兩個數字，並在數字中間加入"Ｘ": 範例__3X11,7X777,8X10');
$type_text = $payload->events[0]->message->text;
if($type_text =='hi'){
    $response1 = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $textMessageBuilder1);
}

$type = $payload->events[0]->type;
if($type == 'message'){
    $receive_text = $payload->events[0]->message->text;
    $receive_num1 = is_numeric(substr($receive_text,0,strpos($receive_text,'X')));
    $receive_num2 = is_numeric(substr(strrchr( $receive_text, 'X' ), 1 ));
    $number_X = substr_count($receive_text,'X');
    if(is_numeric($receive_num1) != TRUE ||is_numeric($receive_num2) != TRUE){
        $reply_text1 = 'Hey 請輸入正確的規格喔!';
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($reply_text1);
        $response2 = $bot->replyMessage($payload->events[0]->replyToken, $textMessageBuilder);
    }
    if($number_X >= 2 ){
        $reply_text2 = '一對染色體最多有2個Ｘ，但我天生只能有一個，歹勢';
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($reply_text2);
        $response2 = $bot->replyMessage($payload->events[0]->replyToken, $textMessageBuilder);
    }
    else{
        $return =$receive_num1*$receive_num2;
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($return);
        $response2 = $bot->replyMessage($payload->events[0]->replyToken, $textMessageBuilder);
    }
        }

//------------------------------------------------
//Echo_Bot
    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

    $type = $payload->events[0]->type;
    if($type == 'message'){
            $receive_text = $payload->events[0]->message->text;
            //$receive_text  = str_replace('嗎', '', $replyText);
            //$receive_text  = str_replace('?', '!', $replyText);
            //$receive_text  = str_replace('？', '！', $replyText);
    }

    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($receive_text);
    $response = $bot->replyMessage($payload->events[0]->replyToken, $textMessageBuilder);

//-----------------------------------------------
//Carousel＿template 旋轉訊息_Message
    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

    $option1 = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('Help','What can I do for you?');
    $option2 = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('Search','What kind of items?');
    $option3 = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('Find','Missing Things, huh?');
    $options = array($option1,$option2,$option3);
    // if(is_array($options)){
    //     echo '$options is array';
    // }else{
    //     echo 'options is not array';
    // };

    //$options = array_push($option1, $option2, $option3);
    // $option_arr= array_map('intval',str_split($options));
    //var_dump ($options);

    $column1 = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('this is menu one','description_test','https://example.com/bot/images/item1.jpg',$options);
    $column2 = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('this is menu two','description_test','https://example.com/bot/images/item1.jpg',$options);
    $columns = array($column1,$column2);

    // if(is_array($columns)){
    //     echo '$columns is array';
    // }else{
    //     echo 'columns is not array';
    // };
    //var_dump ($columns);
    $Carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
    $Carousel_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('This is a Carousel message',$Carousel);
    // echo var_dump($template);
    $response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $Carousel_message);

    // if($response->isSucceeded()){
    //                      echo 'OKOK';

    //                      return;
    //                 }else{
    //                     echo var_dump($response);
    //                 };

    $log->addInfo('hi');

//-----------------------------------------------
//Carousel＿template 旋轉訊息_Uri
    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

    $option1 = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Facebook','https://www.facebook.com/');
    $option2 = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Google','https://www.google.com.tw/');
    $option3 = new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Twitter','https://twitter.com/?lang=zh-tw');
    $options = array($option1,$option2,$option3);

    $column1 = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('this is menu one','description_test','https://example.com/bot/images/item1.jpg',$options);
    $column2 = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('this is menu two','description_test','https://example.com/bot/images/item1.jpg',$options);
    $columns = array($column1,$column2);

    $Carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
    $Carousel_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('This is a Carousel message',$Carousel);
    // echo var_dump($template);
    $response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $Carousel_message);

    if($response->isSucceeded()){
                         echo 'OKOK';
                         return;
                    }else{
                        echo var_dump($response);
                    }

//-----------------------------------------------
//Carousel＿template 旋轉訊息_Postback
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$option1 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Buy','action=add&itemid=111');
$option2 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Add to cart','action=add&itemid=111');
$option3 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Detail','action=more');
$options = array($option1,$option2,$option3);

$column1 = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('this is menu one','description_test','https://example.com/bot/images/item1.jpg',$options);
$column2 = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder('this is menu two','description_test','https://example.com/bot/images/item1.jpg',$options);
$columns = array($column1,$column2);

$Carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
$Carousel_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('This is a Carousel message',$Carousel);
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $Carousel_message);

if($response->isSucceeded()){
                     echo 'OKOK';
                     return;
                }else{
                    echo var_dump($response);
                }

//-----------------------------------------------
//Button_template 單一訊息
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$button_Postback1 = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Buy','action=buy&itemid=123');
$button_Postback2= new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Add to cart','action=add&itemid=123');
$button = array($button_Postback1,$button_Postback2);
if(is_array($button)){
      echo '$options is array';
     }else{
       echo 'options is not array';
     };

$button_button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(
    'this is menu one',
    'description_test',
    'https://example.com/bot/images/item1.jpg',$button);
    //[new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Buy','action=buy&itemid=123'),new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Add to cart','action=add&itemid=123'),new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('View detail','ahttp://example.com/page/123')]);
$button_msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("buttons template", $button_button);
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $button_msg);
if($response->isSucceeded()){
                         echo 'OKOK';
                          return;
                     }else{
                         echo var_dump($response);
                    }
//-----------------------------------------------
//confirm_template 確認訊息
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$data_arr = array('altText'=> 'this is a confirm template',
'text' =>'Are you sure?',
'actions' => array(array(
    'type' => 'message',
    'label' =>'Yes',
    'text' => 'yes'
),
    array(
        'type' => 'message',
        'lebel' => 'No',
        'text' => 'no'
    ))

);
$confirm_Yes = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Yes','yes');
$confirm_No = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('No','no');
$confirm = array($confirm_Yes,$confirm_No);

$confirm = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder('Are you Sure?', $confirm);
$confirm_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("this is a confirm template", $confirm);
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $confirm_message);

//-----------------------------------------------
//回覆文字訊息
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('May I help you');
$response = $bot->replyMessage($payload->events[0]->replyToken, $textMessageBuilder);
//-----------------------------------------------
//回覆語音訊息
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$audioMessageBuilder = new \LINE\LINEBot\MessageBuilder\audioMessageBuilder('https://example.com/original.m4a','60000');
$response = $bot->replyMessage($payload->events[0]->replyToken, $audioMessageBuilder);

//-----------------------------------------------
//發送地點訊息
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$locationMessageBuilder = new \LINE\LINEBot\MessageBuilder\locationMessageBuilder('my location','〒150-0002 東京都渋谷区渋谷２丁目２１−１','35.65910807942215','139.70372892916203');
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $locationMessageBuilder);

if($response->isSucceeded()){
           echo 'OKOK';
           return;
       }
//-----------------------------------------------
//發送語音訊息
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$audioMessageBuilder = new \LINE\LINEBot\MessageBuilder\audioMessageBuilder('https://example.com/original.m4a','60000');
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $audioMessageBuilder);

if($response->isSucceeded()){
           echo 'OKOK';
           return;
       }
//-----------------------------------------------
//發送影片
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$videoMessageBuilder = new \LINE\LINEBot\MessageBuilder\videoMessageBuilder('https://www.youtube.com/watch?v=V5nqUg-S_dg','https://i.imgur.com/Do1jTEI.jpg');
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $videoMessageBuilder);

if($response->isSucceeded()){
          echo 'OKOK';
          return;
      }
//-----------------------------------------------
//發送貼圖
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$StickerMessageBuilder = new \LINE\LINEBot\MessageBuilder\stickerMessageBuilder(1,106);
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $StickerMessageBuilder);

if($response->isSucceeded()){
          echo 'OKOK';
          return;
      }
//-----------------------------------------------
//發送圖片
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder('https://i.imgur.com/Do1jTEI.jpg','https://i.imgur.com/Do1jTEI.jpg');
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $ImageMessageBuilder);

if($response->isSucceeded()){
         echo 'OKOK';
         return;
     }
//-----------------------------------------------
//發送文字訊息
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['line_bot']['channel_access_token']);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['line_bot']['channel_secret']]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('Hiiii');
$response = $bot->pushMessage('U3c3bcb93ce5abb5fcff2b9a297686681', $textMessageBuilder);

if ($response->isSucceeded()) {
    echo 'OKOK';
    return;
}

// echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
