<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:19
 */

namespace Qubes\Support\Applications\Back\Articles\Controllers;

use Qubes\Support\Applications\Back\Base\Controllers\BaseController;

class ArticleController extends BaseController
{
  public function renderIndex()
  {
    return "Articles Home";
  }
}
