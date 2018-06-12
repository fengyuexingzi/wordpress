<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 15:17
 */

// https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=81cc4t9fuu9bpu&redirect_uri=https%3A%2F%2Ffengyuexingzi.top%2Fauth%2Flinkedin&state=987654321&scope=r_basicprofile

register_shutdown_function('shutdown');

function shutdown()
{
    print_r(error_get_last());
    die('shutdown');
}

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
curl_setopt($ch, CURLOPT_POSTFIELDS, build_query($data));
curl_setopt($ch, CURLOPT_TRANSFERTEXT, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_HEADER, false);
$result = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
print_r($info);
var_dump($result);