<?php
/**
 * Index Controller
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Index\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Index\Views\IndexView;

class IndexController extends FrontController
{

  public function renderIndex()
  {
    return $this->setView(new IndexView());
  }

  public function getRoutes()
  {
    return ['/' => 'index'];
  }
}
