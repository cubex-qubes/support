<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support;

use Cubex\Core\Interfaces\INamespaceAware;
use Qubes\Support\Applications\Front\FrontApp;
use Qubes\Support\Applications\Back\BackApp;
use Cubex\Foundation\Container;
use Cubex\Core\Traits\NamespaceAwareTrait;

class Project extends \Cubex\Core\Project\Project implements INamespaceAware
{
  use NamespaceAwareTrait;

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
   * @return \Cubex\Core\Application\Application|null|BackApp|FrontApp
   */
  public function getByPath($path)
  {
    // Back End
    if(starts_with($path, '/admin'))
      return new BackApp();

    // Front End
    return $this->_getFrontApp();
  }

  /**
   * Checks for override FrontApp and returns it
   *
   * @return FrontApp
   * @throws \Exception
   */
  private function _getFrontApp()
  {
    $frontApp = sprintf(
      '%s\Applications\Front\FrontApp',
      $this->getNamespace()
    );

    if(!class_exists($frontApp))
      throw new \Exception($frontApp . ' Not Found');

    return new $frontApp();
  }
}
