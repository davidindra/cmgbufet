<?php

namespace App\Model;

use Nette;

trait OnlyLoggedIn
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
