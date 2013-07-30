<?php
/**
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Qubes\Support\Applications\Back;

use Cubex\Core\Application\Application;
use Qubes\Support\Applications\Back\Articles\Controllers\ArticleController;
use Qubes\Support\Applications\Back\Base\Controllers\DefaultController;
use Qubes\Support\Applications\Back\Categories\Controllers\CategoryController;
use Qubes\Support\Applications\Back\Users\Controllers\UserController;
use Themed\Sidekick\SidekickTheme;

class BackApp extends Application
{
  public function defaultController()
  {
    return new DefaultController();
  }

  public function name()
  {
    return "Support Center";
  }

  public function getRoutes()
  {
    return [
      'admin/categories/(.*)' => new CategoryController(),
      'admin/articles/(.*)'   => new ArticleController(),
      'admin/users/(.*)'   => new UserController()
    ];
  }

  public function getTheme()
  {
    return new SidekickTheme();
  }
}
