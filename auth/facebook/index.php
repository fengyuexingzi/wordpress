<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/15
 * Time: 10:00
 */

require_once '../../vendor/autoload.php';

register_shutdown_function(function () {
    var_dump(error_get_last());
});

try {
    $fb = new \Facebook\Facebook([
        'app_id' => '176954776322838',
        'app_secret' => '8f6335f6d9834f78f0c362d9db15d29b1',
        'default_graph_version' => 'v3.0',
    ]);

} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$helper = $fb->getJavaScriptHelper();
$helper = $fb->getJavaScriptHelper();


try {
    $accessToken = $helper->getAccessToken();
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (!isset($accessToken)) {
    echo 'No cookie set or no OAuth data could be obtained from cookie.';
    exit;
}

// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

$_SESSION['fb_access_token'] = (string)$accessToken;

