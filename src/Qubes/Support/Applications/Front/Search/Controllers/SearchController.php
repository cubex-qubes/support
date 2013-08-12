<?php
namespace Qubes\Support\Applications\Front\Search\Controllers;

use Cubex\Facade\Redirect;
use Cubex\Mapper\Database\SearchObject;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Applications\Front\Search\Views\SearchIndexView;
use Qubes\Support\Components\Content\Article\Mappers\Article;

class SearchController extends FrontController
{

  /**
   * Render the search results index
   *
   * @param string $term
   *
   * @return SearchIndexView
   */
  public function renderIndex($term = '')
  {
    if(!$term)
    {
      $url        = '/';
      $searchPost = $this->request()->postVariables('term');
      if($searchPost)
      {
        $url = '/search/' . urlencode($searchPost);
      }

      Redirect::to($url)->now();
    }

    /** @var SearchIndexView $view */
    $view = $this->getView('SearchIndexView');

    $view->setTerm($term);

    $searchObject = new SearchObject();
    $searchObject->addLike('title', $term);

    // todo currently waiting on http://phabricator.cubex.io/T171
    //$articles = Article::collection($searchObject);

    return $this->setView($view);
  }

  public function getRoutes()
  {
    return array(
      '/search/' => 'index',
      '/search/:term@all/' => 'index',
    );
  }
}

