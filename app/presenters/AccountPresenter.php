<?php

namespace App\Presenters;

use App\Model\Slack;
use Nette;
use App\Model\UserManager;
use Nette\Caching\Storages\FileStorage;
use ondrs\Hi\Hi;
use ondrs\Hi\SimpleCurl;
use Tracy\Debugger;

class AccountPresenter extends BasePresenter
{
	/** @var UserManager @inject */
	public $userManager;

	public function renderDefault()
	{

	}

	public function actionLogin($token = null)
	{
		if($this->user->isLoggedIn()){
			$this->flashMessage('Již jsi přihlášen.');
			$this->redirect('Homepage:');
		}elseif($token) {
			$clientId = $this->secrets->oauthClientID;

			$client = new \Google_Client(['client_id' => $clientId]);
			$payload = $client->verifyIdToken($token);
			if ($payload) {
				$userid = $payload['sub'];
				$email = $payload['email'];
				$name = $payload['name'];
				$domain = @$payload['hd'];

				if($domain == 'cmgpv.cz' || $email == 'mail@davidindra.cz'){
					try{
						$this->user->login($email, $name);
					}catch(Nette\Security\AuthenticationException $e){
						if($e->getCode() == Nette\Security\IAuthenticator::IDENTITY_NOT_FOUND){
							$this->userManager->add($email, $name);
							$this->user->login($email, $name);
							$this->slack->sendMessage('Přihlásil se nový uživatel! :clap: Jmenuje se *' . $name . '*.');
						}else{
							throw $e;
						}
					}

					$hi = new Hi(new FileStorage(__DIR__ . '/../../temp/cache'), new SimpleCurl());
					$this->flashMessage('Ahoj ' . $hi->to(explode(' ', $name)[0])->vocativ . '! :)');
					$this->redirect('Homepage:');
				}else{
					$this->slack->sendMessage('Někdo se pokusil přihlásit do CMGbufetu s nepovolenou e-mailovou adresou ' . $email . '. Bylo tomu zamezeno.');
					$this->flashMessage('Zadaný mail nepatří k doméně @cmgpv.cz, přihlášení nebylo umožněno.');
					$this->redirect('Account:login');
				}
			} else { // Invalid ID token - fake user
				$this->slack->sendMessage('Někdo s IP _' . $_SERVER['REMOTE_ADDR'] . '_ se zřejmě pokusil podvodně přihlásit do CMGbufetu! Jeho gAPI token je `' . $token . '`. @davidindra, prověř to.');
				$this->redirect('Homepage:');
			}
		}
	}

	public function actionLogout($next = false)
	{
		if($next) {
			$this->user->logout();
			$this->flashMessage('Odhlášení proběhlo úspěšně, děkujeme za návštěvu ;)');
			$this->redirect('Homepage:');
		}
	}
}
