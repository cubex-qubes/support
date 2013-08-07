<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:14
 */

namespace Qubes\Support\Applications\Back\Platform\Views;

use Cubex\View\TemplatedViewModel;

class Index extends TemplatedViewModel
{
  protected $_platforms;

  public function __construct($platforms)
  {
    $this->_platforms = $platforms;
  }

  public function getPlatforms()
  {
    return $this->_platforms;
  }
}
