<?php
/**
 * Author: oke.ugwu
 * Date: 02/08/13 08:43
 */

namespace Qubes\Support\Applications\Back\Index;

use Qubes\Support\Applications\Back\Base\BaseBackApp;
use Qubes\Support\Applications\Back\Index\Controllers\DefaultController;

class IndexBackApp extends BaseBackApp
{
  public function __construct()
  {
    $this->setBaseUri('admin');
  }

  public function name()
  {
    return "Support Center - Index";
  }

  public function defaultController()
  {
    return new DefaultController();
  }
}
