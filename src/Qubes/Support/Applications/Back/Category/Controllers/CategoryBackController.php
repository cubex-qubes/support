<?php
/**
 * Author: oke.ugwu
 * Date: 30/07/13 17:13
 */

namespace Qubes\Support\Applications\Back\Category\Controllers;

use Cubex\Data\Transportable\TransportMessage;
use Cubex\Data\Validator\Validator;
use Cubex\Facade\Redirect;
use Cubex\Form\Form;
use Cubex\Routing\Templates\ResourceTemplate;
use Qubes\Support\Applications\Back\Base\Controllers\BaseBackController;
use Qubes\Support\Applications\Back\Category\Views\CategoryForm;
use Qubes\Support\Applications\Back\Category\Views\Index;
use Qubes\Support\Components\Content\Category\Mappers\Category;

class CategoryBackController extends BaseBackController
{
  public function renderIndex()
  {
    $categories = Category::collection()->loadAll();
    return $this->createView(new Index($categories));
  }

  public function renderNew()
  {
    $form = new Form('addCategory', '');
    $form->bindMapper(new Category());

    return $this->createView(new CategoryForm("New Category", $form));
  }

  public function postNew()
  {
    $postData = $this->request()->postVariables();

    $newCategory = new Category();
    $newCategory->hydrateFromUnserialized($postData);
    $newCategory->saveChanges();

    Redirect::to('/' . $this->baseUri())->with(
      'msg',
      new TransportMessage('success', 'New Category was successfully added')
    )->now();
  }

  public function renderEdit()
  {
    $categoryId = $this->getInt('id');
    $form       = new Form('editCategory', '');
    $form->bindMapper(new Category($categoryId));

    return $this->createView(new CategoryForm("Edit Category", $form));
  }

  public function postEdit()
  {
    $postData    = $this->request()->postVariables();
    $newCategory = new Category();
    $newCategory->hydrateFromUnserialized($postData);
    $newCategory->saveChanges();

    Redirect::to('/' . $this->baseUri())->with(
      'msg',
      new TransportMessage('success', 'Category was successfully updated')
    )->now();
  }

  public function renderDestroy()
  {
    $categoryId = $this->getInt('id');
    $category   = new Category($categoryId);
    $category->delete();

    Redirect::to('/' . $this->baseUri())->with(
      'msg',
      new TransportMessage('success', 'Category was successfully deleted')
    )->now();
  }

  public function getRoutes()
  {
    return ResourceTemplate::getRoutes();
  }
}
