<?php
namespace Qubes\Support\Applications\Front\Contact\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Applications\Front\Contact\Forms\ContactForm;

class ContactView extends FrontView
{
  public function getForm()
  {
    $form = new ContactForm;

    return $form;
  }
}
