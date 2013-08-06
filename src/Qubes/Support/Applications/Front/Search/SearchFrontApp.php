<?php
namespace Qubes\Support\Applications\Front\Search;

use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Front\Search\Controllers\SearchController;

class SearchFrontApp extends BaseFrontApp
{
  public function defaultController()
  {
    return new SearchController();
  }
}
