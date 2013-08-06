<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:06
 */

namespace Qubes\Support\Applications\Back\Base;

use Cubex\Core\Application\Application;
use Qubes\Support\Applications\Back\Base\Controllers\DefaultController;
use Themed\Sidekick\SidekickTheme;

class BaseBackApp extends Application
{
  public function __construct()
  {
    $this->_listen(__NAMESPACE__);
    $this->setBaseUri('/admin');
  }

  public function name()
  {
    return "Support Center";
  }

  public function defaultController()
  {
    return new DefaultController();
  }

  public function getRoutes()
  {
    return [
      'category/(.*)' => 'CategoryBackController',
      'article/(.*)'  => 'ArticleBackController',
      'platform/(.*)' => 'PlatformBackController',
      'user/(.*)'     => 'UserController'
    ];
  }

  public function getTheme()
  {
    return new SidekickTheme();
  }
}
