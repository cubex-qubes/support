<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 16:33
 */

namespace Qubes\Support\Components\User\Mappers;

use Cubex\Mapper\Database\RecordMapper;

class User extends RecordMapper
{
  public $username;
  public $email;
  public $password;
  public $displayName;
}
