<?php

namespace App\Model;

use App\Model\Entity\Product;
use App\Model\Repository\Products;
use Nette;
use Nette\Http\Session;
use Nette\Http\SessionSection;

/**
 * Class Cart maintains user's cart content saved in a session
 * @package App\Model
 */
class Cart
{
    use Nette\SmartObject;

    /** @var SessionSection */
    private $cartSession;

    /** @var Products */
    private $products;

    /**
     * Cart constructor.
     * @param Session $session
     * @param Products $products
     */
    public function __construct(Session $session, Products $products)
    {
        $this->cartSession = $session->getSection('cart');
        $this->products = $products;
    }

    /**
     * Adds an item into user's cart
     * @param int $id
     * @return Product
     * @throws CartException when item with that ID doesn't exist
     */
    public function add($id){
        if($this->products->getById($id) != null) {

            $this->cartSession[$id] = intval($this->cartSession[$id]) + 1;
            return $this->products->getById($id);

        }else{
            throw new CartException('There isn\'t a product with ID ' . $id . '.');
        }
    }

    /**
     * Removes an item from user's cart
     * @param int $id
     * @return true
     * @throws CartException when item with this ID isn't in user's cart
     */
    public function remove($id){
        if(isset($this->cartSession[$id])){
            if($this->cartSession[$id] == 1){
                unset($this->cartSession[$id]);
            }else{
                $this->cartSession[$id] = $this->cartSession[$id] - 1;
            }
            return true;
        }else{
            throw new CartException('There\'s not an item in the cart with ID ' . $id . '.');
        }
    }

    /**
     * Get cart content
     * @return array[]
     */
    public function cart(){
        $cart = [];
        foreach($this->cartSession as $id => $amount){
            $cart[$id] = ['product' => $this->products->getById($id), 'amount' => $amount];
        }
        return $cart;
    }

    /**
     * Calculate number of total items that are currently in user's cart
     * @return int
     */
    public function itemsTotal(){
        $cart = [];
        foreach($this->cartSession as $id => $amount){
            $cart[$id] = $amount;
        }
        return array_sum($cart);
    }

    /**
     * Summarize the value of all items in the cart
     * @param bool $better should we take the better price, or the worse?
     * @return int
     */
    public function sum($better = true){
        $sum = 0;
        foreach ($this->cartSession as $id => $amount) {
            $sum +=
                $amount *
                ($better
                    ? $this->products->getById($id)->priceBetter
                    : $this->products->getById($id)->priceWorse);
        }
        return $sum;
    }

    /**
     * Remove all contents of user's cart
     * @return true
     */
    public function purge(){
        $this->cartSession->remove();
        return true;
    }
}

/**
 * Class CartException
 * @package App\Model
 */
class CartException extends \Exception
{
}
