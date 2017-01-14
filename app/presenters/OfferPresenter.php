<?php

namespace App\Presenters;

use App\Model\Repository\Products;
use Nette;

class OfferPresenter extends BasePresenter
{
	/** @var Products @inject */
	public $products;

	public function renderDefault()
	{
		$this->template->products = $this->products->getAll();
	}

	public function actionEdit()
	{
		
	}
	
	public function handleRemove()
	{
	    
	}
}
