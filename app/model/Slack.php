<?php

namespace App\Model;

use Nette;
use GuzzleHttp\Client;
//use GuzzleHttp\Cookie\CookieJar;
use Tracy\Debugger;

class Slack
{
    use Nette\SmartObject;

    private $webhook;

    /**
     * @var Client
     */
    private $guzzle;

    /**
     * @var CookieJar carries cookies between requests
     *
    private $jar;*/
    
    public function __construct()
    {
        //$this->jar = new CookieJar; // setup cookie jar

        $this->webhook = json_decode(file_get_contents(__DIR__ . '/../config/secrets.json'))->slackWebHook;

        $this->guzzle = new Client([
            /*'base_uri' => $webhook,
            'cookies' => $this->jar,
            'allow_redirects' => true*/
        ]);
    }

    public function sendMessage($text){
        $json = [
            'username' => 'CMGbufet',
            'icon_url' => 'https://cmgbufet.cz/img/logo.png',
            /*'channel' => 'general',*/
            'text' => $text
        ];

        try {
            $this->guzzle->request('post', $this->webhook, ['json' => $json]);
        }catch(Exception $e){
            throw new SlackException('Slack message sending failed.', 0, $e);
        }
    }
}

class SlackException extends \Exception
{
}
