<?php
/**
 * Index Controller
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Index\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Index\Views\IndexView;
use Qubes\Support\Applications\Front\Base\Views\FrontView;

class IndexController extends FrontController
{

  /**
   * Render the Home page
   *
   * @return IndexView
   */
  public function renderIndex()
  {
    /** @var IndexView $view */
    $view = $this->getView('IndexView');

    return $view;
  }

  public function getRoutes()
  {
    return ['/' => 'index'];
  }
}
