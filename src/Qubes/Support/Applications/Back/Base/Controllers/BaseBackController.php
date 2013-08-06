<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:46
 */

namespace Qubes\Support\Applications\Back\Base\Controllers;

use Cubex\Core\Controllers\WebpageController;
use Cubex\Facade\Redirect;
use Cubex\Routing\StdRoute;
use Cubex\Routing\Templates\ResourceTemplate;
use Cubex\View\HtmlElement;
use Qubes\Support\Applications\Back\Base\Views\Header;
use Qubes\Support\Applications\Back\Base\Views\Sidebar;

abstract class BaseBackController extends WebpageController
{
  public function preRender()
  {
    $this->requireCss('base', __NAMESPACE__);
    $this->tryNest('sidebar', $this->getSidebar());
    $this->tryNest('header', $this->getHeader());
  }

  public function canProcess()
  {
    if(!\Auth::loggedIn())
    {
      Redirect::to('/' . $this->baseUri())->now();
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
    Redirect::to('/' . $this->baseUri())->now();
  }

  public function defaultAction()
  {
    return "index";
  }
}
