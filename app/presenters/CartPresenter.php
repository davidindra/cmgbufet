<?php

namespace App\Presenters;

use Nette;
use App\Model\OnlyLoggedIn;
use App\Model\CartException;

class CartPresenter extends BaseOnlyLoggedInPresenter
{
	public function renderDefault()
	{
		$this->template->cart = $this->cart;
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

	public function renderSummary($type){
		$this->template->cart = $this->cart;
		$this->template->type = $type;

		if($this->cart->itemsTotal() == 0 || !isset($type)){
			$this->redirect('Cart:');
		}
	}
}
