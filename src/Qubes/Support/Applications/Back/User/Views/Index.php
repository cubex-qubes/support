<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:14
 */

namespace Qubes\Support\Applications\Back\User\Views;

use Cubex\View\TemplatedViewModel;

class Index extends TemplatedViewModel
{
  protected $_users;

  public function __construct($users)
  {
    $this->_users = $users;
  }

  public function getUsers()
  {
    return $this->_users;
  }
}
