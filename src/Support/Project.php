<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Support;

class Project extends \Cubex\Core\Project\Project
{
  /**
   * Project Name
   *
   * @return string
   */
  public function name()
  {
    return "Support Center";
  }

  /**
   * @return \Cubex\Core\Application\Application
   */
  public function defaultApplication()
  {
    return new Applications\Www\WwwApplication();
  }
}
