<?php

namespace App\Presenters;

use App\Model\Cart;
use Nette;
use App\Model;
use App\Model\Slack;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected $secrets;

    /** @var Slack @inject */
    public $slack;

    /** @var Cart @inject */
    public $cart;

    public function startup()
    {
        $this->secrets = json_decode(file_get_contents(__DIR__ . '/../config/secrets.json'));

        parent::startup();
    }

    public function beforeRender()
    {
        if($this->user->isLoggedIn()){
            $this->template->cart = $this->cart;
        }

        if($this->isAjax()) {
            $this->redrawControl('title');
            //$this->redrawControl('nav');
            $this->redrawControl('content');
            $this->redrawControl('pageNameJS');
            $this->redrawControl('flashes');

            if($this->user->isLoggedIn()){
                $this->redrawControl('cartItemsNumber');
            }
        }

        $this->setupFilters();

        parent::beforeRender();
    }

    private function setupFilters(){
        $this->template->addFilter('dump', function ($input) {
            $html = new Nette\Utils\Html();
            return $html->setHtml(Debugger::dump($input, true));
        });

        $this->template->addFilter('markdown', function($input) {
            $md = \Parsedown::instance();
            $html = new Nette\Utils\Html();
            return $html->setHtml($md->line($this->template->getLatte()->invokeFilter('breaklines', [$input])));
        });
    }
}
