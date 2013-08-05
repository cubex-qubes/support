<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:06
 */

namespace Qubes\Support\Applications\Back\Base;

use Cubex\Core\Application\Application;
use Qubes\Support\Applications\Back\Article\Controllers\ArticleController;
use Qubes\Support\Applications\Back\Base\Controllers\DefaultController;
use Qubes\Support\Applications\Back\Category\Controllers\CategoryController;
use Qubes\Support\Applications\Back\Platform\Controllers\PlatformController;
use Qubes\Support\Applications\Back\User\Controllers\UserController;
use Themed\Sidekick\SidekickTheme;

class BaseApp extends Application
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
      'categories/(.*)' => new CategoryController(),
      'articles/(.*)'   => new ArticleController(),
      'platforms/(.*)'  => new PlatformController(),
      'users/(.*)'      => new UserController()
    ];
  }

  public function getTheme()
  {
    return new SidekickTheme();
  }
}
