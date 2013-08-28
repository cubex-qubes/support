<?php
namespace Qubes\Support;

use Bundl\Debugger\DebuggerBundle;
use Cubex\Core\Application\Application;
use Cubex\Core\Interfaces\INamespaceAware;
use Cubex\Foundation\Container;
use Cubex\Core\Traits\NamespaceAwareTrait;
use Cubex\Dispatch\Utils\ListenerTrait;
use Cubex\Theme\ApplicationTheme;

class Project extends \Cubex\Core\Project\Project implements INamespaceAware
{
  use NamespaceAwareTrait;
  use ListenerTrait;

  public function getNestedViews()
  {
    return ['sidebar'];
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

  public function isExtended()
  {
    return Container::config()->get('project')->extended;
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
    if($config->extended)
    {
      $config->extended_path = __DIR__;
      $config->extended_namespace = __NAMESPACE__;
    }

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
      '/contact'     => 'Contact',
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

    // Attempt to find the override App
    if($this->isExtended())
    {
      $extendedClassName = sprintf(
        '%s\Applications\%s\%s\%s%sApp',
        $this->getNamespace(),
        $namespace,
        $appRoutes[$path],
        $appRoutes[$path],
        $namespace
      );

      if(class_exists($extendedClassName))
      {
        return new $extendedClassName($this);
      }
    }

    $baseClassName = sprintf(
      'Qubes\Support\Applications\%s\%s\%s%sApp',
      $namespace,
      $appRoutes[$path],
      $appRoutes[$path],
      $namespace
    );

    if(class_exists($baseClassName))
    {
      return new $baseClassName($this);
    }

    $message = sprintf(
      'Could not find %s',
      $baseClassName
    );
    throw new \Exception($message, 500);
  }

  public function getTheme(Application $app)
  {
    return new ApplicationTheme($app);
  }
}
