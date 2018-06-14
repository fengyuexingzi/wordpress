<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 15:17
 */

require_once "./function.php";

// get_code_url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=81cc4t9fuu9bpu&redirect_uri=https%3A%2F%2Ffengyuexingzi.top%2Fauth%2Flinkedin&state=Wf6tYXQ7y86iRulBOC%2FUXraHneM%3D&scope=r_fullprofile%20r_emailaddress%20w_share";

$state = base64_encode(openssl_random_pseudo_bytes(20));
session_start();
$_SESSION['state'] = $state;

if (isset($_SESSION['info'])) {
    dump($_SESSION['info']);
    unset($_SESSION['info']);
}

$tokenInfo = [
    'access_token' => 'AQUhXDdWEWNdYAn6zHrahzIWATYDW4OptdpCPmAcPoSW9mIIdUwhpQj8XLTIIP1PyDBUs5hyUb86it8GQNS7kcsW3o4QggkAiswA2c3X-nO8byjQBaIiRoQuyGpboEN672NRWgB6B7PvtX4Gujz6BWf0sUPvIITKRdF_PoasfDrits5TJGsnJZZFxm8JzDamQ8Xt4tzal1zMqundj1I5OxyGWhdl9uGuly9M2NfsZZ6_qxT0b7OnaWUU6dq5uKVSqsR_QY8HlDgBtw-HGvODNHMmPhtigjrdcoMaztobvNj7ReTMWN-TNhWLEb4QZaoWCG2X7b9bXnUYi1Cbp_VZoOaj_jMRug',
    'expires_in' => '1534052395',
];

if ($tokenInfo['expires_in'] < time()) {
    $html = <<<EOF
<a href="${url}">获取授权</a>
EOF;
} else {
    $hdrs = [
        'http' => [
            'header' =>
                "Accept: application/json\r\n" .
                "Authorization: Bearer ${tokenInfo['access_token']}",
            'timeout' => 2
        ],
    ];
    $context = stream_context_create($hdrs);
    echo file_get_contents('https://api.linkedin.com/v1/people/~?format=json', 0, $context);
}

function getCodeUrl()
{
    $url = 'https://www.linkedin.com/oauth/v2/authorization?';
    $data = array(
        'response_type' => 'code',
        'client_id' => '81cc4t9fuu9bpu',
        'redirect_uri' => 'https://fengyuexingzi.top/auth/linkedin/callback.php',
        'state' => $GLOBALS['state'],
        'scope' => 'r_basicprofile r_emailaddress w_share',
    );
    foreach ($data as $k => $v) {
        if (!$v) {
            return false;
        }
    }
    $url .= http_build_query($data, null, '&', PHP_QUERY_RFC3986);

    return $url;
}

$url = getCodeUrl();

echo $html;
