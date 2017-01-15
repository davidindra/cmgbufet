<?php

namespace App\Model;

use Nette;

trait OnlyAdmin
{
    public function startup()
    {
        if(!$this->user->isInRole('admin')){
            $this->flashMessage('Pro přístup na tuto stránku musíš být administrátorem.');
            $this->redirect('Homepage:');
        }

        parent::startup();
    }
}
