<?php
$app->get(
    '/login',
    function ($response) use (
        $app,
        $error_arr
    ) {
        try {
            include_once '../api/sso-login/login.html';
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

$app->get(
    '/sso',
    function ($response) use (
        $app,
        $error_arr
    ) {
        try {
            include_once '../api/sso-login/sso.html';
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

$app->get(
    '/logout',
    function ($response) use (
        $app,
        $error_arr
    ) {
        try {
            include_once '../api/sso-login/logout.html';
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
