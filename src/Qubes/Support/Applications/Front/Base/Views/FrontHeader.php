<?php
/**
 * Default Front-end Header
 *
 * @author Jay Francis <jay.francis@justdevelop.it>
 */

namespace Qubes\Support\Applications\Front\Base\Views;

use Cubex\Facade\Auth;
use Cubex\View\Partial;
use Cubex\View\RenderGroup;
use Cubex\View\ViewModel;

class FrontHeader extends ViewModel
{
  public function __construct()
  {
  }

  public function render()
  {
    $menus = [
      'Home View'           => '/',
      'Category View'       => '/category/1-example',
      'Article View'        => '/article/1-example',
      'Search Results View' => '/search/example',
    ];

    $navItems = new Partial(
      '<li class="%s">
        <a href="%s" title="%s">%s</a></li>',
      null,
      false
    );

    foreach($menus as $text => $url)
    {
      $state = '';
      $navItems->addElement(
        $state,
        $url,
        $text,
        $text
      );
    }

    return new RenderGroup(
      '<a id="support-logo" class="brand" href="/">',
      'Support Center</a>',
      '<ul class="nav">',
      $navItems,
      '</ul>'
    );
  }
}
