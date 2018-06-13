<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13
 * Time: 10:51
 */

register_shutdown_function('shutdown');

function shutdown()
{
    $error = error_get_last();
    if ($error) {
        echo '<pre>';
        print_r($error);
        echo '</pre>';
    }
}

function dump($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
