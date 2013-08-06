<?php
namespace Qubes\Support\Applications\Front\Article;

use Qubes\Support\Applications\Front\Article\Controllers\ArticleController;
use Qubes\Support\Applications\Front\Base\BaseFrontApp;

class ArticleFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    return new ArticleController();
  }
}
