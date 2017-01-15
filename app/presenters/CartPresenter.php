<?php

namespace App\Presenters;

use Nette;
use App\Model\OnlyLoggedIn;
use App\Model\CartException;

class CartPresenter extends BaseOnlyLoggedInPresenter
{
	public function renderDefault()
	{

	}

	public function handleRemove($id){
		try{
			$this->cart->remove($id);
		}catch(CartException $e){
			$this->flashMessage('Zboží s ID ' . intval($id) . ' se v košíku nenachází.');
		}

		$this->flashMessage('Zboží bylo z košíku odebráno.');

		$this->redrawContent = false;
	}
}
