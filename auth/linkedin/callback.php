<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13
 * Time: 10:50
 */

require_once "./function.php";

session_start();

$state = 'x1Dr3Nu0AaxM1TuLVuGwAJWM';

// step 1: get access token by code
function getAccessToken($code)
{
    $url = "https://www.linkedin.com/oauth/v2/accessToken";

    $data = array(
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => 'https://fengyuexingzi.top/auth/linkedin',
        'client_id' => '81cc4t9fuu9bpu',
        'client_secret' => 'GdY3ZO8LAHn8y4tX',
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_TRANSFERTEXT, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    $result = json_decode($result, true);
    if (isset($result['access_token'])) {

    }
}

// step 2: get user info by access token
function getInfo($url, $access_token)
{
    // 1. 判断 AccessToken 状态（过期，即将过期，正常，无效）
    // 2.AccessToken 1）无效或过期，回到 step 1 重新请求; 2）即将过期， 调用刷新接口；3）正常使用

    $data = [
        'access_token' => "AQXMRNlQv7rqemb6KmBKMWurtL7I6KV381MUxXQIeW6YszIueblWCVatVrVACzO-L2wWI7VSgto_hvH_ET1E7aVUjAalRXvcEu4qsWx57YS1yVANEbpez3dQUupIRrqGOGnokRHR64nQyVFqTPaS9e2hPvO_miOtlBD3mzQjxLC1O2xxJrG4BIWohlNmMyxgvVXM2OZCurPG5rFyfoitB-rmI6JyvW4tUYRFoJLe5XzjfpUWoe0OUzWxo8y67xrY4tIBAILKGnMM2KDfHKyVJx9JDoVC7jCPHaWC9mSEWSSlunC5Q_xJuJb98MPwDUlrtXkvpJSC9yzbsODR_nnBr5coHEcIlA",

    ];

    $info_url = "https://api.linkedin.com/v1/people/~?format=json";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $access_token,
    ]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    $info['result'] = $result;
    curl_close($ch);

    return $info;
}

if ($_GET['state'] != $state) {
    die('hack');
}

//$access_token = getAccessToken($_GET['code']);

dump($_SESSION);