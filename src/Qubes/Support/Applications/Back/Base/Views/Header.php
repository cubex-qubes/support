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
      'Categories' => 'admin/category',
      'Articles'   => 'admin/article',
      'Platforms'  => 'admin/platform',
      'Users'      => 'admin/user'
    ];

    $navItems = new Partial(
      '<li class="%s">
        <a href="%s" title="%s">%s</a></li>'
      , null, false);

    $currPath = $this->request()->path();
    foreach($menus as $item => $path)
    {
      $state = starts_with($currPath, "/$path", false) ? 'active' : '';
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
          <li><a href="/admin/access/logout">Logout</a></li>
        </ul>
      </div>'
    );
  }
}
