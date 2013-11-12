<?php
/**
 * @category   PHP asynchronous request
 * @author     <eriks.zviedrans@gmail.com>
 * @link       https://github.com/EriksZviedrans/PHP-asynchronous-request
 */

/**
 * write a random number into file
 * @param  integer $number  random number
 * @return <null>
 */
function writeToFile($number) {
    sleep(30);
    $fp = fopen('data', 'w');
    fwrite($fp, $number);
    fclose($fp);
}
require_once("async.php");
$async = new Async_request();
try {
    $async->asyncExecute_writeToFile(rand ( 10 , 100 ));
} catch(Exception $e) {
    echo $e->getMessage();
}

?>