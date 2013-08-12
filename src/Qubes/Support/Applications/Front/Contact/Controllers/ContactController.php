<?php
namespace Qubes\Support\Applications\Front\Contact\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Contact\Views\ContactView;

class ContactController extends FrontController
{

  /**
   * Render a Contact Form
   *
   * @param $id
   *
   * @return ContactView
   */
  public function renderContactForm($id)
  {

    /** @var ContactView $view */
    $view = $this->getView('ContactView');

    return $this->setView($view);
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/contact' => 'contactForm',
    ];
  }
}
