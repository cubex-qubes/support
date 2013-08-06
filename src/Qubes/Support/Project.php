<?php
namespace Qubes\Support;

use Bundl\Debugger\DebuggerBundle;
use Cubex\Core\Interfaces\INamespaceAware;
use Cubex\Foundation\Container;
use Cubex\Core\Traits\NamespaceAwareTrait;
use Cubex\Dispatch\Utils\ListenerTrait;

class Project extends \Cubex\Core\Project\Project implements INamespaceAware
{
  use NamespaceAwareTrait;
  use ListenerTrait;


  /**
   * @return array
   */
  public function getBundles()
  {
    return [
      //      new DebuggerBundle()
    ];
  }

  /**
   * Get the path for the project that includes override templates
   *
   * @return string
   */
  public function getProjectPath()
  {
    return __DIR__;
  }

  /**
   * Initiate the project
   *
   * @return $this
   */
  public function init()
  {
    $this->_setProjectPathConfig();
    $this->_setProjectExtendedConfig();

    return $this;
  }

  /**
   * Set the Project path, and a flag it as extended
   *
   * @return $this
   */
  private function _setProjectPathConfig()
  {
    $config       = Container::config()->get('project');
    $config->path = $this->getProjectPath();

    return $this;
  }

  /**
   * Determine if the project has been extended and set result in config
   *
   * @return $this
   */
  private function _setProjectExtendedConfig()
  {
    $config           = Container::config()->get('project');
    $config->extended = !($this->getProjectPath() == __DIR__);

    return $this;
  }

  /**
   * Get the project title
   *
   * @return string
   */
  public function getTitle()
  {
    return 'Support';
  }

  /**
   * Get the project name
   *
   * @return string
   */
  public function getName()
  {
    return 'Support Name';
  }

  /**
   * Project Name
   *
   * @return string
   */
  public function name()
  {
    return $this->getName();
  }

  /**
   * @return \Cubex\Core\Application\Application|void
   * @throws \Exception
   */
  public function defaultApplication()
  {
    throw new \Exception('Not Implemented');
  }

  public function getByPath($path)
  {
    $basePath = $this->request()->offsetPath(0, 1);

    if($basePath == '/admin')
    {
      return $this->_getBackApp();
    }

    return $this->_getFrontApp();
  }

  private function _getFrontApp()
  {
    $appRoutes = [
      '/'            => 'Index',
      '/article'     => 'Article',
      '/category'    => 'Category',
      '/search'      => 'Search',
      '/video'       => 'Video',
      '/walkthrough' => 'Walkthrough',
    ];

    return $this->_getApp($appRoutes);
  }

  private function _getBackApp()
  {
    $appRoutes = [
      '/'            => 'Index',
      '/article'     => 'Article',
      '/category'    => 'Category',
      '/platform'    => 'Platform',
      '/user'        => 'User',
      '/search'      => 'Search',
      '/video'       => 'Video',
      '/walkthrough' => 'Walkthrough',
      '/access'      => 'Access',
    ];

    $path = $this->request()->offsetPath(1, 1);

    return $this->_getApp($appRoutes, 'Back', $path);
  }

  private function _getApp(
    array $appRoutes = array(),
    $namespace = 'Front',
    $path = null
  )
  {
    $path = $path ? $path : $this->request()->path(1);

    if(!array_key_exists($path, $appRoutes))
    {
      throw new \Exception("No Application Defined for '$path'", 404);
    }

    $className = sprintf(
      '%s\Applications\%s\%s\%s%sApp',
      $this->getNamespace(),
      $namespace,
      $appRoutes[$path],
      $appRoutes[$path],
      $namespace
    );

    if(!class_exists($className))
    {
      throw new \Exception($className . ' Not Found');
    }

    return new $className();
  }
}
