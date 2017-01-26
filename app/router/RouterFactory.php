<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('kosik/<action>/<type>', [
			'presenter' => 'Cart',
			'action' => [
				Route::VALUE => 'default',
				Route::FILTER_TABLE => [
					'shrnuti' => 'summary',
					'dokonceni' => 'complete',
				]
			],
			'type' => [
				Route::VALUE => null,
				Route::FILTER_TABLE => [
					'predem' => 1,
					'hotove' => 2
				]
			]
		]);
		$router[] = new Route('<presenter>[/<action>]', [
			'presenter' => [
				Route::VALUE => 'Homepage',
				Route::FILTER_TABLE => [
					'ucet' => 'Account',
					'kosik' => 'Cart',
					'kredit' => 'Credit',
					'nabidka' => 'Offer'
				],
			],
			'action' => [
				Route::VALUE => 'default',
				Route::FILTER_TABLE => [
					'prihlasit' => 'login',
					'odhlasit' => 'logout',
					'uspech' => 'paypalSuccess',
					'shrnuti' => 'summary'
				]
			]
		]);
		return $router;
	}

}
