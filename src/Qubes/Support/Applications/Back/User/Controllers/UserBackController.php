<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:21
 */

namespace Qubes\Support\Applications\Back\User\Controllers;

use Cubex\Data\Transportable\TransportMessage;
use Cubex\Facade\Redirect;
use Cubex\Form\Form;
use Cubex\Routing\Templates\ResourceTemplate;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Applications\Back\User\Views\Index;
use Qubes\Support\Applications\Back\User\Views\UserForm;
use Qubes\Support\Components\User\Mappers\User;

class UserBackController extends BaseBackController
{
  public function renderIndex()
  {
    $users = User::collection()->loadAll();
    return new Index($users);
  }

  public function renderNew()
  {
    $form = new Form('addUser', '');
    $form->bindMapper(new User());

    return new UserForm("New User", $form);
  }

  public function postNew()
  {
    $postData = $this->request()->postVariables();

    $newUser = new User();
    $newUser->hydrateFromUnserialized($postData);
    $newUser->password = password_hash($newUser->password, PASSWORD_DEFAULT);
    $newUser->saveChanges();

    Redirect::to('/' . $this->baseUri())->with(
      'msg',
      new TransportMessage('success', 'New User was successfully added')
    )->now();
  }

  public function renderEdit()
  {
    $userId = $this->getInt('id');
    $form   = new Form('editUser', '');
    $form->bindMapper(new User($userId));

    return new UserForm("Edit User", $form);
  }

  public function postEdit()
  {
    $postData = $this->request()->postVariables();
    $newUser  = new User($postData['id']);

    if($postData['password'] == '')
    {
      $newUser->username    = $postData['username'];
      $newUser->email       = $postData['email'];
      $newUser->displayName = $postData['display_name'];
    }
    else
    {
      $newUser->hydrateFromUnserialized($postData);
      $newUser->password = password_hash($newUser->password, PASSWORD_DEFAULT);
    }
    $newUser->saveChanges();

    Redirect::to('/' . $this->baseUri())->with(
      'msg',
      new TransportMessage('success', 'User was successfully updated')
    )->now();
  }

  public function renderDestroy()
  {
    $userId = $this->getInt('id');

    $user = new User($userId);
    $user->delete();

    Redirect::to('/' . $this->baseUri())->with(
      'msg',
      new TransportMessage('success', 'User was successfully deleted')
    )->now();
  }

  public function getRoutes()
  {
    return ResourceTemplate::getRoutes();
  }
}
