<?php

namespace App\Presenters;

use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected $secrets;

    public function startup()
    {
        $this->secrets = json_decode(file_get_contents(__DIR__ . '/../config/secrets.json'));

        parent::startup();
    }

    public function beforeRender()
    {
        $this->redrawControl('pageNameJS');
        $this->redrawControl('flashes');

        parent::beforeRender();
    }
}
