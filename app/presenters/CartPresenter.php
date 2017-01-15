<?php

namespace App\Presenters;

use App\Model\Repository\Products;
use Nette;
use App\Model\OnlyLoggedIn;

class CartPresenter extends BasePresenter
{
	use OnlyLoggedIn;

	/** @var Products @inject */
	public $products;

	/** @var Nette\Http\SessionSection */
	private $cart;

	public function startup()
	{
		$this->cart = $this->session->getSection('cart');

		parent::startup();
	}

	public function renderDefault()
	{
		$this->template->products = $this->products;

		$this->template->cartPriceBetterSum = 0;
		$this->template->cartPriceWorseSum = 0;
		foreach ($this->cart as $id => $amount) {
			$this->template->cartPriceBetterSum += $this->products->getById($id)->priceBetter * $amount;
			$this->template->cartPriceWorseSum += $this->products->getById($id)->priceWorse * $amount;
		}
	}

	public function handleRemove($id){
		if(isset($this->cart[$id])){
			if($this->cart[$id] == 1){
				unset($this->cart[$id]);
			}else{
				$this->cart[$id] = $this->cart[$id] - 1;
			}

			$this->flashMessage('Zboží bylo z košíku odebráno.');
		}else{
			$this->flashMessage('Zboží s ID ' . intval($id) . ' se v košíku nenachází.');
		}

		$this->redrawControl('content', false);
	}
}
