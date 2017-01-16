<?php

namespace App\Presenters;

use Nette;

class CreditPresenter extends BaseOnlyLoggedInPresenter
{
	public function renderDefault()
	{
		$this->template->creditRecords = $this->credits->getByUser($this->user->id, true);
	}

	public function actionPaypalSuccess()
	{
		$this->flashMessage('Platba byla přijata! :) Připsána bude za pár chvil.');
		$this->redirect('Credit:');
	}
}
