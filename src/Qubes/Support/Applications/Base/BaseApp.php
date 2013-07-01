<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Qubes\Support\Applications\Base;

use Cubex\Core\Application\Application;

class BaseApp extends Application
{
  public function defaultDispatcher()
  {
    return 'DefaultController';
  }

  public function name()
  {
    return "Support Center";
  }

}
