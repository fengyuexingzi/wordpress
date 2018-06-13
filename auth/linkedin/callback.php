<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13
 * Time: 10:50
 */

require_once "./function.php";

session_start();
$state = $_SESSION['state'];

// step 1: get access token by code
function getAccessToken($code)
{
    $url = "https://www.linkedin.com/oauth/v2/accessToken";

    $data = array(
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => 'https://fengyuexingzi.top/auth/linkedin/callback.php',
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
        return $result['access_token'];
    }

    return $result;
}

// step 2: get user info by access token
function getInfo($access_token)
{
    $url = "https://api.linkedin.com/v1/people/~?format=json";

    // 1. 判断 AccessToken 状态（过期，即将过期，正常，无效）
    // 2.AccessToken 1）无效或过期，回到 step 1 重新请求; 2）即将过期， 调用刷新接口；3）正常使用

    $data = [
        'access_token' => 'AQUhXDdWEWNdYAn6zHrahzIWATYDW4OptdpCPmAcPoSW9mIIdUwhpQj8XLTIIP1PyDBUs5hyUb86it8GQNS7kcsW3o4QggkAiswA2c3X-nO8byjQBaIiRoQuyGpboEN672NRWgB6B7PvtX4Gujz6BWf0sUPvIITKRdF_PoasfDrits5TJGsnJZZFxm8JzDamQ8Xt4tzal1zMqundj1I5OxyGWhdl9uGuly9M2NfsZZ6_qxT0b7OnaWUU6dq5uKVSqsR_QY8HlDgBtw-HGvODNHMmPhtigjrdcoMaztobvNj7ReTMWN-TNhWLEb4QZaoWCG2X7b9bXnUYi1Cbp_VZoOaj_jMRug',
        'expires_in' => '1534052395',
    ];


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $data['access_token'],
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

// 防止 CSRF 跨站请求伪造
if ($_GET['state'] != $state) {
    die('hack');
}
unset($_SESSION['state']);

//$access_token = getAccessToken($_GET['code']);

// 请求 access_token 失败
//if (is_array($access_token)) {
//    dump($access_token);
//    die;
//}

// 此处应保存至数据库或 Redis

$info = getInfo();
$info = json_encode($info);

header("Location: https://fengyuexingzi.top/auth/linkedin?access_token=${info}");
