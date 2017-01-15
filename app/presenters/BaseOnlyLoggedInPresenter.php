<?php

namespace App\Presenters;

use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BaseOnlyLoggedInPresenter extends BasePresenter
{
    public function startup()
    {
        if(!$this->user->isLoggedIn()){
            $this->flashMessage('Pro přístup na tuto stránku musíš být přihlášen.');
            $this->redirect('Account:login');
        }

        parent::startup();
    }
}
