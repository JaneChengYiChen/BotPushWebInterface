<?php
$querystring = $_SERVER['QUERY_STRING'];
parse_str($querystring, $output);
$code = $output['code'];

$client = new GuzzleHttp\Client();

//get token
$uri = $_ENV['sso']['api_host'] . "/token";
$response = $client->request(
    'POST',
    $uri,
    [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
        'form_params' => ['grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $_ENV['sso']['redirectURI'],
            'client_id' => $_ENV['sso']['clientId']],
    ]
);
$payload = json_decode($response->getBody());
$token = $payload->access_token;

//將token存入cookie
$expires = time() + 86400; //目前的 timestamp + 秒數
$path = "/console"; //根目錄，整個網站都能使用，預設會是網頁當下的目錄
$domain = ""; //目前的 domain，只可設定為子網域，不可設定成其他網域
$secure = false;
$name = "tokens";
$value = $token;

setcookie($value, $expires, $path, $domain, $secure);
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://localhost:9008/console");
exit;
