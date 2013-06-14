<?php
/**
 * Tickets Application
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Support\Applications\Tickets;

use Cubex\Core\Application\Application;

class TicketsApp extends Application
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
