<?php
namespace Qubes\Support\Applications\Front\Contact;

use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Front\Contact\Controllers\ContactController;

class ContactFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    /** @var ContactController $controller */
    $controller = $this->getController('ContactController');

    return $controller;
  }
}
