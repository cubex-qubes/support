<?php
namespace Qubes\Support\Components\User\Mappers;

use Cubex\Mapper\Database\RecordMapper;

class User extends RecordMapper
{
  public $username;
  public $email;
  public $password;
  public $displayName;
}
