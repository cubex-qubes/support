<?php
namespace Qubes\Support\Applications\Front\Search\Controllers;

use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Search\Views\SearchIndexView;

class SearchController extends FrontController
{

  /**
   * Render the search results index
   *
   * @param string $search
   *
   * @return SearchIndexView
   */
  public function renderIndex($search = '')
  {
    /** @var SearchIndexView $view */
    $view = $this->getView('SearchIndexView');

    return $view;
  }

  public function getRoutes()
  {
    return array(
      '/search/:search@all' => 'index',
    );
  }
}
