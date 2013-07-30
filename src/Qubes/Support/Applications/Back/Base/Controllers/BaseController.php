<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:46
 */

namespace Qubes\Support\Applications\Back\Base\Controllers;

use Cubex\Core\Controllers\WebpageController;
use Cubex\Facade\Redirect;
use Cubex\View\HtmlElement;
use Qubes\Support\Applications\Back\Base\Views\Header;
use Qubes\Support\Applications\Back\Base\Views\Sidebar;

class BaseController extends WebpageController
{
  public function preRender()
  {
    $this->nest('sidebar', $this->getSidebar());
    $this->nest('header', $this->getHeader());
  }

  public function canProcess()
  {
    if(!\Auth::loggedIn())
    {
      Redirect::to('/admin')->now();
    }
    return true;
  }

  public function getSidebar()
  {
    return new Sidebar();
  }

  public function getHeader()
  {
    return new Header();
  }

  public function logout()
  {
    \Auth::logout();
    Redirect::to('/admin')->now();
  }

  public function defaultAction()
  {
    return "index";
  }

  public function getRoutes()
  {
    return ['logout' => 'logout'];
  }
}
