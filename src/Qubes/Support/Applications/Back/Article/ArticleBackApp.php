<?php
/**
 * Author: oke.ugwu
 * Date: 02/08/13 09:41
 */

namespace Qubes\Support\Applications\Back\Article;

use Qubes\Support\Applications\Back\Article\Controllers\ArticleBackController;
use Qubes\Support\Applications\Back\Base\BaseBackApp;

class ArticleBackApp extends BaseBackApp
{
  public function __construct()
  {
    $this->setBaseUri('admin/article');
  }

  public function name()
  {
    return "Support Center - Article";
  }

  public function defaultController()
  {
    return new ArticleBackController();
  }

  public function getRoutes()
  {
    return [
      "/" => [
        "/:id@num/section/(.*)" => "ArticleSectionBackController",
        "(.*)"                  => "ArticleBackController",
      ]
    ];
  }
}
