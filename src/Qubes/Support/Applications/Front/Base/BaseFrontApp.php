<?php
/**
 * Handle the routing to each of the front end applications
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Qubes\Support\Applications\Front\Base;

use Cubex\Core\Application\Application;
use Cubex\Foundation\Container;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Themed\Sidekick\SidekickTheme;

abstract class BaseFrontApp extends Application
{

  public function init()
  {
    $this
    ->_setGlobalCss()
    ->_setGlobalJs();
  }

  private function _setGlobalCss()
  {
    Container::config()->get('project')->css = (array)$this->getGlobalCss();

    return $this;
  }

  private function _setGlobalJs()
  {
    Container::config()->get('project')->js = (array)$this->getGlobalJs();

    return $this;
  }

  public function getGlobalCss()
  {
    return [];
  }

  public function getGlobalJs()
  {
    return [];
  }

  /**
   * Map standard routes to the controllers
   *
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    $controllers = [
      "/"              => 'Index',
      "/article/(.*)"  => 'Article',
      "/category/(.*)" => 'Category',
      "/search/(.*)"   => 'Search',
    ];

    $routes = [];
    foreach($controllers as $route => $controller)
    {
      $routes[$route] = $this->_getControllerClass($controller);
    }

    return $routes;
  }

  /**
   * Check for overrides then return the correct controller class name
   *
   * @param $controllerName
   *
   * @return FrontController
   * @throws \Exception
   */
  private function _getControllerClass($controllerName)
  {
    $config = Container::config()->get('project');
    if($config->extended)
    {
      $extendedClass = sprintf(
        '%s\%s\Controllers\%sController',
        $this->getNamespace(),
        $controllerName,
        $controllerName
      );

      if(class_exists($extendedClass))
      {
        return $extendedClass;
      }
    }

    $controllerClass = sprintf(
      '\Qubes\Support\Applications\Front\%s\Controllers\%sController',
      $controllerName,
      $controllerName
    );

    if(!class_exists($controllerClass))
    {
      throw new \Exception($controllerClass . ' Not Found');
    }

    return $controllerClass;
  }

  /**
   * Set the default project theme
   *
   * @return \Cubex\Theme\ApplicationTheme|SidekickTheme
   */
  public function getTheme()
  {
    return new SidekickTheme;
  }
}
