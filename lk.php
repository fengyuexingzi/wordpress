<?php
/**
 * Created by PhpStorm.
 * User: LN007
 * Date: 2018/7/3
 * Time: 9:11
 */

file_put_contents('./lk.txt', json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);