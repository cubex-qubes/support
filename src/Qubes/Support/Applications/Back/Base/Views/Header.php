<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:43
 */

namespace Qubes\Support\Applications\Back\Base\Views;

use Cubex\Facade\Auth;
use Cubex\View\Partial;
use Cubex\View\RenderGroup;
use Cubex\View\ViewModel;

class Header extends ViewModel
{
  public function __construct()
  {
  }

  public function render()
  {
    $menus = [
      'Categories' => 'admin/categories',
      'Articles'   => 'admin/articles',
      'Users'      => 'admin/users'
    ];

    $navItems = new Partial(
      '<li class="%s">
        <a href="%s" title="%s">%s</a></li>'
      , null, false);

    foreach($menus as $item => $path)
    {
      $state = '';
      $navItems->addElement(
        $state,
        '/' . $path,
        $item,
        $item
      );
    }

    return new RenderGroup(
      '<a id="support-logo" class="brand" href="/admin">',
      'Support Center</a>',
      '<ul class="nav">',
      $navItems,
      '</ul>',
      '<div class="nav-collapse collapse">
        <ul class="nav pull-right">
          <li><a href="/admin/profile">' . Auth::getRawUsername() . '</a></li>
          <li><a href="/admin/logout">Logout</a></li>
        </ul>
      </div>'
    );
  }
}
