<?php
/**
 * Description
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Applications\Front\Base\Controllers;

use Cubex\Core\Controllers\WebpageController;
use Cubex\Foundation\Container;
use Cubex\Foundation\IRenderable;
use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Cubex\View\Templates\Errors\Error404;

abstract class FrontController extends WebpageController
{
  public function preProcess()
  {
    $this->_addProjectResources();
  }

  /**
   * Add base project resources, JD, CSS etc
   *
   * @return $this
   */
  private function _addProjectResources()
  {
    $config = Container::config()->get('project');
    if(!$config->extended)
    {
      $this->requireCss(
        'http://twitter.github.com/bootstrap/assets/css/bootstrap.css'
      );
      $this->requireCss('/base');

      $this->requireJs('http://code.jquery.com/jquery-latest.js');
      $this->requireJs(
        'http://twitter.github.com/bootstrap/assets/js/bootstrap.min.js'
      );
    }

    return $this;
  }

  public function renderNotFound()
  {
    $this->webpage()->setStatusCode("404");

    return new Error404();
  }

  public function defaultAction()
  {
    return "notFound";
  }

  /**
   * Set the view, as the sidebars will be determined by the different views
   *
   * @param IRenderable $view
   */
  public function setView(IRenderable $view)
  {
    if($view instanceof FrontView)
    {
      $sidebar = $view->getSidebar();
      if($sidebar !== null && $sidebar instanceof IRenderable)
      {
        $this->nest("sidebar", $sidebar);
      }
    }
    $this->nest("content", $view);
  }
}
