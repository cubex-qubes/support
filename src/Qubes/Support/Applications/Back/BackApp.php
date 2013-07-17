<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Qubes\Support\Applications\Back;

use Cubex\Core\Application\Application;

// todo nothing has been added for the back end yet
class BackApp extends Application
{
  public function defaultDispatcher()
  {
    return 'DefaultController';
  }

  public function name()
  {
    return "Support Center";
  }

  public function getRoutes()
  {
    return [
      "/category/:category" => "someControlMethod"
    ];
  }

}
