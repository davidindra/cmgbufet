<?php

namespace App\Model;

use Nette;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Tracy\Debugger;

class Slack
{
    use Nette\SmartObject;

    /**
     * @var Client
     */
    private $guzzle;

    /**
     * @var CookieJar carries cookies between requests
     */
    private $jar;
    
    public function __construct()
    {
        $this->jar = new CookieJar; // setup cookie jar

        $webhook = json_decode(file_get_contents(__DIR__ . '/../config/secrets.json'))->slackWebHook;

        $this->guzzle = new Client([
            'base_uri' => $webhook,
            'cookies' => $this->jar,
            'allow_redirects' => true
        ]); // setup GuzzleHTTP library
    }

    public function sendMessage($text){

    }
}

class SlackException extends \Exception
{
}
