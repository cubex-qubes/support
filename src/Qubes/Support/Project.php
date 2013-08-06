<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support;

use Bundl\Debugger\DebuggerBundle;
use Cubex\Core\Interfaces\INamespaceAware;
use Cubex\Facade\Auth;
use Qubes\Support\Applications\Back\Login\LoginApp;
use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Back\BackApp;
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
      new DebuggerBundle()
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

  /**
   * Initial Routing to Application
   *
   * @param $path
   *
   * @return \Cubex\Core\Application\Application|null|BackApp|BaseFrontApp
   */
  public function getByPath($path)
  {
    // Back End
    if(starts_with($path, '/admin'))
    {
      return $this->_getBackApp();
    }

    // Front End
    return $this->_getFrontApp();
  }

  /**
   * @return LoginApp|BaseFrontApp
   */
  private function _getBackApp()
  {
    $appMap = array(
      ''         => 'Index',
      'category' => 'Category',
      'article'  => 'Article',
      'video'    => 'Video',
      'search'   => 'Search',
    );

    if(!Auth::loggedin())
    {
      return new LoginApp();
    }

    // Strip /admin
    $path = $this->request()->offsetPath(1);

    return $this->_getApp($appMap, $path, 'Back');
  }

  /**
   * @return BaseFrontApp
   */
  private function _getFrontApp()
  {
    $appMap = array(
      ''         => 'Index',
      'category' => 'Category',
      'article'  => 'Article',
      'video'    => 'Video',
      'search'   => 'Search',
    );

    return $this->_getApp($appMap, 'Front');
  }

  /**
   * Checks for override App class and returns it
   *
   * @param array  $appMap
   * @param        $path
   * @param string $base
   *
   * @throws \Exception
   * @return BaseFrontApp|BackApp
   */
  private function _getApp(
    array $appMap = array(),
    $base = 'Front',
    $path = null
  )
  {
    $path     = $path ? $path : $this->request()->path();
    $uriParts = explode('/', ltrim($path, '/'));
    $baseUrl  = current($uriParts);

    if(!array_key_exists($baseUrl, $appMap))
    {
      throw new \Exception("No Application Defined for '$baseUrl'", 404);
    }

    $className = sprintf(
      '%s\Applications\%s\%s\%s%sApp',
      $this->getNamespace(),
      $base,
      $appMap[$baseUrl],
      $appMap[$baseUrl],
      $base
    );

    if(!class_exists($className))
    {
      throw new \Exception($className . ' Not Found');
    }

    return new $className();
  }
}
