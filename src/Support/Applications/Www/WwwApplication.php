<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Support\Applications\Www;

use Cubex\Core\Application\Application;

class WwwApplication extends Application
{
  public function defaultDispatcher()
  {
    return 'DefaultController';
  }

  public function getBundles()
  {
    return [
      //'debugger' => new \Bundl\Debugger\DebuggerBundle()
    ];
  }

  public function name()
  {
    return "Support Center";
  }

  public function getNamespace()
  {
    return __NAMESPACE__;
  }
}
