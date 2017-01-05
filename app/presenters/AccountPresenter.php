<?php

namespace App\Presenters;

use Nette;
use Tracy\Debugger;

class AccountPresenter extends BasePresenter
{
	public function renderDefault()
	{

	}

	public function actionLogin($token = null)
	{
		if($token) {
			$clientId = $this->secrets->oauthClientID;

			$client = new \Google_Client(['client_id' => $clientId]);
			$payload = $client->verifyIdToken($token);
			if ($payload) {
				$userid = $payload['sub'];
				$email = $payload['email'];
				$name = $payload['name'];
				$domain = $payload['hd'];

				if($domain == 'cmgpv.cz'){
					$this->flashMessage('Přihlášení proběhlo úspěšně!');
				}else{
					$this->flashMessage('Zadaný mail nepatří k doméně @cmgpv.cz, přihlášení nebylo umožněno.');
				}
			} else {
				// Invalid ID token - fake user, do nothing
			}

			$this->redirect('Homepage:'); // TODO move to offer as we'll have some
		}
	}

	public function actionLogout($next = false)
	{
		if($next) {
			$this->user->logout(true);
			$this->flashMessage('Odhlášení proběhlo úspěšně!');
			$this->redirect('Homepage:');
		}
	}
}
