<?php
/**
 * @category   PHP asynchronous request
 * @author     zviederi <eriks.zviedrans@gmail.com>
 * @link       https://github.com/EriksZviedrans/PHP-asynchronous-request
 */

class Async_request {
    /**
     * Port
     * @var asynchronous request port
     */
    public $port = 81;

    /**
     * __call catch function name and parameters
     * @param  string $method function name
     * @param  array  $params function parameters
     * @return <null>
     */
    public function __call($function, $params) {
        $real_function = str_replace('asyncExecute_', '', $function);
        if(!function_exists($real_function))
            throw new RuntimeException("The called function does not exist.");
        $reflection = new ReflectionFunction($real_function);
        $this->post_async($real_function, $params);
        echo 'Function executed';
    }

     /**
     * post_async execute asynchronous request.
     * @see http://blog.markturansky.com/archives/205
     * @return <null>
     */
    public function post_async($function, $params) {

        $url = "http://localhost:".$this->port."/async/index.php?async=".$function;

        $post_params = array();

        foreach ($params as $key => &$val)
        {
            if (is_array($val)) $val = implode(',', $val);
            $post_params[] = $key.'='.urlencode($val);
        }

        $post_string = implode('&', $post_params);
        $post_string = 'async='.$function.'&'.$post_string;
        $parts       = parse_url($url);
        $fp = fsockopen($parts['host'], isset($parts['port'])?$parts['port']:80,$errno, $errstr);

        $out = "POST ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($post_string)."\r\n";
        $out.= "Connection: Close\r\n\r\n";
        if (isset($post_string)) $out.= $post_string;
        fwrite($fp, $out);
        fclose($fp);
    }

    /**`
     * call function
     * @return <null>
     */
    public function execute() {
        $request  = $_REQUEST;
        $function = (string)$request['async'];
        unset($request['async']);
        /**
         * There we can use a Reflection class
         */
        require 'functions.php';
        call_user_func_array($function, $request);
    }
}
?>