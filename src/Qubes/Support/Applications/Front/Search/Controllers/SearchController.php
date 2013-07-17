<?php
/**
 * Search Controller
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Search\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Search\Views\SearchIndexView;

class SearchController extends FrontController
{

  public function renderIndex()
  {
    return $this->setView(new SearchIndexView());
  }

  public function getRoutes()
  {
    return array(
      '/:search@all' => 'index',
    );
  }
}
