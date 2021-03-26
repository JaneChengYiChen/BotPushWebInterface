<?php
$app->get(
    '/console',
    function ($response) use (
        $app,
        $error_arr
    ) {
        try {
            //headers指從這個 API 的哪個部分來獲知請求中的內容是使用何種編碼方式
            //key:content-type
            //value:application/json
            //從key字段中知道是用何種value編碼
            $response->getHeader('Content-Type', 'application/json');
            $token = $response->getHeader('token');
            // $payload = $app->request()->getBody();
            // $payload = json_decode($payload);
            // if ($token != null) {
            include_once '../api/console/index.html';
            // }
        } catch (Exception $e) {
            $err_json = json_decode($e->getMessage());
            if (!$err_json) {
                echo json_encode(
                    [
                        'code' => 1900,
                        'message' => $e->getMessage(),
                        'line' => $e->getLine(),
                    ]
                );
                exit;
            }
            $err_log["code"] = $err_json->code;
            $err_log["error_msg"] = $err_json->message;
            http_response_code($error_arr[$err_json->code]['status']);
            echo $e->getMessage();
            exit;
        }
    }
);
