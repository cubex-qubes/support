<?php
namespace Qubes\Support\Applications\Front\Base;

use Cubex\Core\Application\Application;
use Cubex\Foundation\Container;
use Cubex\Theme\ApplicationTheme;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Category\Controllers\CategoryController;
use Qubes\Support\Project;
use Themed\Sidekick\SidekickTheme;

abstract class BaseFrontApp extends Application
{
  protected $_project;

  function __construct(\Cubex\Core\Project\Project $project)
  {
    $this->_project = $project;
  }


  /**
   * Get the application name
   *
   * @return mixed
   */
  public function getApplicationName()
  {
    $classParts = explode('\\', get_called_class());

    array_pop($classParts);

    return end($classParts);
  }

  public function getProjectNamespace()
  {
    return $this->getProject()->getNamespace();
  }

  public function isExtended()
  {
    return $this->getProject()->isExtended();
  }

  public function getController($className, $applicationName = null)
  {
    if(!$applicationName)
    {
      $applicationName = $this->getApplicationName();
    }

    if($this->isExtended())
    {
      $class = sprintf(
        '%s\Applications\Front\%s\Controllers\%s',
        $this->getProjectNamespace(),
        $applicationName,
        $className
      );

      if(class_exists($class))
      {
        return new $class();
      }
    }

    $class = sprintf(
      'Qubes\Support\Applications\Front\%s\Controllers\%s',
      $applicationName,
      $className
    );

    if(!class_exists($class))
    {
      throw new \Exception($class . ' Not Found');
    }

    return new $class();
  }

  /**
   * @return Project
   */
  public function getProject()
  {
    return $this->_project;
  }

  public function init()
  {
    $this
    ->_setGlobalCss()
    ->_setGlobalJs();
  }

  private function _setGlobalCss()
  {
    $css                                     = $this->getProject()
                                               ->getGlobalCss();
    Container::config()->get('project')->css = $css;

    return $this;
  }

  private function _setGlobalJs()
  {
    $js                                     = $this->getProject()->getGlobalJs(
    );
    Container::config()->get('project')->js = $js;

    return $this;
  }

  /**
   * Set the default project theme
   *
   * @return \Cubex\Theme\ApplicationTheme|SidekickTheme
   */
  public function getTheme()
  {
    if(Container::config()->get('project')->extended)
    {
      return $this->getProject()->getTheme($this);
    }

    return new SidekickTheme;
  }
}
