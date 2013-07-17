<?php
/**
 * Handle the routing to each of the front end applications
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */
namespace Qubes\Support\Applications\Front;

use Cubex\Core\Application\Application;

class FrontApp extends Application
{

  /**
   * Set the theme
   *
   * @return \Cubex\Theme\ApplicationTheme|void
   * @throws \Exception
   */
  public function getTheme()
  {
    throw new \Exception('Theme not implemented');
  }

  /**
   * Map base routes to the controllers
   *
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    $indexClass = '\Qubes\Support\Applications\Front\Index\Controllers'
      . '\IndexController';

    $articleClass = '\Qubes\Support\Applications\Front\Article\Controllers'
      . '\ArticleController';

    $categoryClass = '\Qubes\Support\Applications\Front\Category\Controllers'
      . '\CategoryController';

    $searchClass = '\Qubes\Support\Applications\Front\Search\Controllers'
      . '\SearchController';

    return [
      "/"              => $indexClass,
      "/article/(.*)"  => $articleClass,
      "/category/(.*)" => $categoryClass,
      "/search/(.*)"   => $searchClass,
    ];
  }
}
