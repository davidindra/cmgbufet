<?php

namespace App\Presenters;

use Nette;

class CreditPresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->creditRecords = $this->credits->getByUser($this->user->id, true);
	}

	public function actionEdit()
	{
		
	}
	
	public function handleRemove()
	{
	    
	}
}
