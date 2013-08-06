<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:25
 */

namespace Qubes\Support\Applications\Back\Access\Views;

use Cubex\Facade\Session;
use Cubex\Form\Form;
use Cubex\View\HtmlElement;
use Cubex\View\RenderGroup;
use Cubex\View\ViewModel;

class Login extends ViewModel
{
  public function render()
  {
    $form = new Form('login');
    $form->addTextElement('username');
    $form->addPasswordElement('password');
    $form->addSubmitElement('Login');

    $alert = '';
    if(Session::getFlash('msg'))
    {
      $alert = new HtmlElement(
        'div',
        ['class' => 'alert alert-error'],
        Session::getFlash('msg')
      );
    }

    return new RenderGroup(
      '<h1>Please Login</h1>',
      $alert,
      $form
    );
  }
}
