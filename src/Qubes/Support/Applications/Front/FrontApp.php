<?php
/**
 * Handle the routing to each of the front end applications
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Qubes\Support\Applications\Front;

use Cubex\Core\Application\Application;
use Cubex\Foundation\Container;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;

class FrontApp extends Application
{

  /**
   * Set the theme
   *
   * @return \Cubex\Theme\ApplicationTheme|void
   * @throws \Exception
   */
  public function getTheme()
  {
    throw new \Exception('Theme not implemented');
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
        return $extendedClass;
    }

    $controllerClass = sprintf(
      '\Qubes\Support\Applications\Front\%s\Controllers\%sController',
      $controllerName,
      $controllerName
    );

    if(!class_exists($controllerClass))
      throw new \Exception($controllerClass . ' Not Found');

    return $controllerClass;
  }
}
