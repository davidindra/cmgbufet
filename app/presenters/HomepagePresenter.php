<?php

namespace App\Presenters;

use Nette;
use App\Model;
use App\Model\Slack;


class HomepagePresenter extends BasePresenter
{
	/** @inject @var Slack */
	public $slack;

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
