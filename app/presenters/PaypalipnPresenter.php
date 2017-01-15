<?php

namespace App\Presenters;

use Nette;
use Tracy\Debugger;

class PaypalipnPresenter extends BasePresenter
{
    public function renderDefault()
    {
        if ($this->verifyIPN()) {
            //mail('mail@davidindra.cz', 'PP-IPN', Debugger::dump($_POST, true));
            $this->slack->sendMessage(
                '**Příchozí platba!**' . implode('<br>', $_POST)
            );

            header("HTTP/1.1 200 OK");
            die();
        }
    }

    private function verifyIPN()
    {
        if (!count($_POST)) {
            throw new \Exception("Missing POST Data");
        }
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = [];
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }
        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        //$ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
        //$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
        $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);
        $res = curl_exec($ch);
        if (!($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL error: [$errno] $errstr");
        }
        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        if ($http_code != 200) {
            throw new \Exception("PayPal responded with http code $http_code");
        }
        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == 'VERIFIED') {
            return true;
        } else {
            return false;
        }
    }
}
