<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:13
 */

namespace Qubes\Support\Applications\Back\Platform\Controllers;

use Cubex\Facade\Redirect;
use Cubex\Form\Form;
use Cubex\Routing\Templates\ResourceTemplate;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Applications\Back\Platform\Views\PlatformForm;
use Qubes\Support\Applications\Back\Platform\Views\Index;
use Qubes\Support\Components\Content\Platform\Mappers\Platform;

class PlatformBackController extends BaseBackController
{
  public function renderIndex()
  {
    $platforms = Platform::collection()->loadAll();
    return new Index($platforms);
  }

  public function renderNew()
  {
    $form = new Form('addPlatform', '');
    $form->bindMapper(new Platform());

    return new PlatformForm("New Platform", $form);
  }

  public function postNew()
  {
    $postData = $this->request()->postVariables();
    //unset id so mapper can save.
    //see http://phabricator.cubex.io/T170
    unset($postData['id']);
    $newPlatform = new Platform();
    $newPlatform->hydrateFromUnserialized($postData);
    $newPlatform->saveChanges();

    $msg       = new \stdClass();
    $msg->type = 'success';
    $msg->text = 'New Platform was successfully added';

    Redirect::to('/' . $this->baseUri())->with('msg', $msg)->now();
  }

  public function renderEdit()
  {
    $platformId = $this->getInt('id');
    $form       = new Form('editPlatform', '');
    $form->bindMapper(new Platform($platformId));
    return new PlatformForm("Edit Platform", $form);
  }

  public function postEdit()
  {
    $postData    = $this->request()->postVariables();
    $newCategory = new Platform();
    $newCategory->hydrateFromUnserialized($postData);
    $newCategory->saveChanges();

    $msg       = new \stdClass();
    $msg->type = 'success';
    $msg->text = 'Platform was successfully updated';

    Redirect::to('/' . $this->baseUri())->with('msg', $msg)->now();
  }

  public function renderDestroy()
  {
    $platformId = $this->getInt('id');
    $platform   = new Platform($platformId);
    $platform->delete();

    $msg       = new \stdClass();
    $msg->type = 'success';
    $msg->text = 'Platform was successfully deleted';

    Redirect::to('/' . $this->baseUri())->with('msg', $msg)->now();
  }

  public function getRoutes()
  {
    return ResourceTemplate::getRoutes();
  }
}
