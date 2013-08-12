<?php
namespace Qubes\Support\Applications\Front\Contact\Forms;

use Cubex\Data\Validator\Validator;
use Cubex\Form\Form;
use Cubex\Form\FormElement;

class ContactForm extends Form
{
  function __construct()
  {
    parent::__construct('contact');
  }

  protected function _configure()
  {
    $this->setDefaultElementTemplate('<dt>{{label}}</dt><dd>{{input}}</dd>');

    $this->addSubmitElement('Send', 'submit');
  }
}
