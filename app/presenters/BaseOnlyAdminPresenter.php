<?php

namespace App\Presenters;

use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BaseOnlyAdminPresenter extends BasePresenter
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
