<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:12
 */

namespace Qubes\Support\Applications\Back\Base\Controllers;

use Cubex\View\HtmlElement;
use Cubex\View\RenderGroup;
use Qubes\Support\Applications\Back\Base\Controllers\BaseController;

class DefaultController extends BaseController
{
  public function renderIndex()
  {
    return new HtmlElement('h1', [], 'Hello Admin');
  }
}
