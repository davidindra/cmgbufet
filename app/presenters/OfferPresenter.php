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

	public function handleBuy($id)
	{
		if(!$this->user->isLoggedIn()){
			$this->redirect('Account:login');
		}elseif($this->user->isInRole('cantbuy')){
			$this->flashMessage('Máš zablokováno nakupování.');
			$this->redirect('Offer:');
		}

		$this->flashMessage('Produkt&nbsp;<b>' . $this->products->getById($id)->name . '</b>&nbsp;byl přidán do košíku.');
	}
}
