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
    echo '<pre>';
    print_r(error_get_last());
    echo '</pre>';
}

function dump($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
