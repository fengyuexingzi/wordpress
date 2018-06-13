<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 15:17
 */

$code_url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=81cc4t9fuu9bpu&redirect_uri=https%3A%2F%2Ffengyuexingzi.top%2Fauth%2Flinkedin&state=987654321&scope=r_basicprofile";

$data = [
    'access_token' => "AQXMRNlQv7rqemb6KmBKMWurtL7I6KV381MUxXQIeW6YszIueblWCVatVrVACzO-L2wWI7VSgto_hvH_ET1E7aVUjAalRXvcEu4qsWx57YS1yVANEbpez3dQUupIRrqGOGnokRHR64nQyVFqTPaS9e2hPvO_miOtlBD3mzQjxLC1O2xxJrG4BIWohlNmMyxgvVXM2OZCurPG5rFyfoitB-rmI6JyvW4tUYRFoJLe5XzjfpUWoe0OUzWxo8y67xrY4tIBAILKGnMM2KDfHKyVJx9JDoVC7jCPHaWC9mSEWSSlunC5Q_xJuJb98MPwDUlrtXkvpJSC9yzbsODR_nnBr5coHEcIlA",

];

$info_url = "https://api.linkedin.com/v1/people/~?format=json";

register_shutdown_function('shutdown');

function shutdown()
{
    echo '<pre>';
    print_r(error_get_last());
    echo '</pre>';
    die('shutdown');
}

function dump($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function curl_get($url, $data)
{
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

$result = curl_get($info_url, $data);

dump($result);

die;

$url = "https://www.linkedin.com/oauth/v2/accessToken";

$data = array(
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
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
