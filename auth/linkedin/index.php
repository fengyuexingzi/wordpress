<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 15:17
 */

require_once "./function.php";

// get_code_url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=81cc4t9fuu9bpu&redirect_uri=https%3A%2F%2Ffengyuexingzi.top%2Fauth%2Flinkedin&state=Wf6tYXQ7y86iRulBOC%2FUXraHneM%3D&scope=r_fullprofile%20r_emailaddress%20w_share";

// $state = base64_encode(openssl_random_pseudo_bytes(20));
$state = 'x1Dr3Nu0AaxM1TuLVuGwAJWM';

function getCodeUrl()
{
    $url = 'https://www.linkedin.com/oauth/v2/authorization';
    $data = array(
        'response_type' => 'code',
        'client_id' => '81cc4t9fuu9bpu',
        'redirect_uri' => 'https://fengyuexingzi.top/auth/linkedin',
        'state' => $GLOBALS['state'],
        'scope' => 'r_fullprofile r_emailaddress w_share',
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

$html = <<<EOF
<a href="${url}">获取授权</a>
EOF;

echo $html;
