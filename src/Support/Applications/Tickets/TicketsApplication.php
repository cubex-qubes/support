<?php
/**
 * Tickets Application
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Project\Applications\Tickets;

use Cubex\Core\Application\Application;

class TicketsApplication extends Application
{
  public function defaultDispatcher()
  {
    return 'DefaultController';
  }

  public function name()
  {
    return "Tickets";
  }

  public function getNamespace()
  {
    return __NAMESPACE__;
  }
}
