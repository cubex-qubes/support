<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:06
 */

namespace Qubes\Support\Applications\Back\Base;

use Cubex\Core\Application\Application;
use Themed\Sidekick\SidekickTheme;

abstract class BaseBackApp extends Application
{
  public function init()
  {
    $this->_listen(__NAMESPACE__);
  }

  public function name()
  {
    return "Support Center";
  }

  public function getTheme()
  {
    return new SidekickTheme();
  }
}
