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

  /**
   * Render the search results index
   *
   * @param null $search
   *
   * @return SearchIndexView
   */
  public function renderIndex($search = null)
  {
    /** @var SearchIndexView $view */
    $view = $this->getView('SearchIndexView');

    return $view;
  }

  public function getRoutes()
  {
    return array(
      '/:search@all' => 'index',
    );
  }
}
