<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\UrlShortManager;
use Nette\Application\UI\Form;
use Nette;
use Nette\Utils\ArrayHash;
use Nette\Utils\Validators;
use Nette\Http\Request;


class HomepagePresenter extends Nette\Application\UI\Presenter
{

	/** @var App\Model\UrlShortManager */
	private $urlShortManager;

	public function __construct( UrlShortManager $urlShortManager)
	{
		$this->urlShortManager = $urlShortManager;
	}

	public function actionRed( ): void
	{
		$url = $this->getHttpRequest()->getUrl()->getPath();
		$url = ltrim($url, '/');
		$sUrl = $this->urlShortManager->getUrl( $url );

		$this->redirectUrl($sUrl);
	}

	public function renderDefault(): void
	{
		$this->template->urls = $this->urlShortManager->getUrls();
		bdump($this->template->urls);
	}


	public function handleAddRedirect( int $id ):void
	{

		$url = $this->urlShortManager->insertRed( $id );

		$this->redirectUrl($url);

	}

	public function createComponentAddUrlForm(): Form
	{
		$form = new Form;

		$form->addText('long_url', _('Vložená url'))
			->setRequired();

		$form->addSubmit('send', _('Zkrátit'));

		$form->onSuccess[] = [$this, 'formSuccess'];
		
		return $form;
	}

	public function formSuccess( Form $form, ArrayHash $values)
	{

		$this->urlShortManager->shortUrl( $values['long_url'] );

		$this->redirect('this');

	}
 	
}
