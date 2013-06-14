<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Support;

use Cubex\Core\Application\Application;
use Support\Applications\Base\BaseApp;
use Support\Applications\Tickets\TicketsApp;

class Project extends \Cubex\Core\Project\Project
{
  protected $_apps = array();

  protected function _configure()
  {
    $this->_addApplication('base', new BaseApp());
    $this->_addApplication('tickets', new TicketsApp());
  }

  private function _addApplication($path, Application $application)
  {
    $this->_apps[$path] = $application;

    return $this;
  }

  /**
   * Project Name
   *
   * @return string
   */
  public function name()
  {
    return "Support Tickets";
  }

  /**
   * @return \Cubex\Core\Application\Application
   */
  public function defaultApplication()
  {
    return new BaseApp();
  }
}
