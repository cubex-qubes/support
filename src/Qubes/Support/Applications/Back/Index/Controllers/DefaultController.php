<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:12
 */

namespace Qubes\Support\Applications\Back\Index\Controllers;

use Cubex\View\HtmlElement;
use Cubex\View\RenderGroup;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;

class DefaultController extends BaseBackController
{
  public function renderIndex()
  {
    return new HtmlElement('h1', [], 'Hello Admin');
  }
}
