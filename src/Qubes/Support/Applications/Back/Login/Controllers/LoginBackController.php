<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:24
 */

namespace Qubes\Support\Applications\Back\Login\Controllers;

use Cubex\Auth\StdLoginCredentials;
use Cubex\Facade\Auth;
use Cubex\Facade\Redirect;
use Cubex\View\RenderGroup;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Applications\Back\Login\Views\Login;

class LoginBackController extends BaseBackController
{
  public function canProcess()
  {
    return true;
  }

  public function renderIndex()
  {
    return new Login();
  }

  public function postIndex()
  {
    $postData = $this->request()->postVariables();
    $user     = Auth::authByCredentials(
      StdLoginCredentials::make(
        $postData['username'],
        $postData['password']
      )
    );

    if($user && Auth::loggedIn())
    {
      Redirect::to('/admin')->now();
    }
    else
    {
      Redirect::to('/admin')->with(
        'msg',
        'Login Failed, please check username and password is correct'
      )->now();
    }
  }

  public function getHeader()
  {
    return new RenderGroup(
      '<a id="support-logo" class="brand" href="/admin">',
      ('Support Center</a>'));
  }

  public function getSidebar()
  {
    return null;
  }

  public function getRoutes()
  {
    return [
      '/' => 'index'
    ];
  }
}
