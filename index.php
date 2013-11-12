<?php
/**
 * @category   PHP asynchronous request
 * @author     zviederi <eriks.zviedrans@gmail.com>
 * @link       https://github.com/EriksZviedrans/PHP-asynchronous-request
 */
if(isset($_REQUEST['async'])) {
    require_once("async.php");
    Async_request::execute();
}
?>