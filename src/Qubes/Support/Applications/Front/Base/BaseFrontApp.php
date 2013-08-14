<?php
namespace Qubes\Support\Applications\Front\Base;

use Cubex\Core\Application\Application;
use Cubex\Foundation\Container;
use Cubex\Theme\ApplicationTheme;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
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
