<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:25
 */

namespace Qubes\Support\Applications\Back\Category\Views;

use Cubex\View\TemplatedViewModel;
use Qubes\Support\Components\Content\Category\Mappers\Category;

class CategoryForm extends TemplatedViewModel
{
  public $heading;
  protected $_form;

  /**
   * @param string            $heading
   * @param  \Cubex\Form\Form $form
   */
  public function __construct($heading, $form)
  {
    $this->heading = $heading;
    $this->_form   = $form;
    $this->_form->getElement('title')->setRequired(true);
    $this->_form->getElement('subTitle')->setRequired(true);

    $value = $this->_form->getElement('parentCategoryId')->rawData();
    $id    = $this->_form->getElement('id')->rawData();

    //child cannot be a parent of its parent
    $exception = Category::collection(['parent_category_id' => $id])
                 ->getUniqueField('id');

    //grand children not allowed to be parents of grand parents
    $grandChildren = Category::collection()->whereIn(
                                'parent_category_id',
                                $exception
                              )->getUniqueField('id');

    $exception = array_merge($exception, $grandChildren);

    //category cannot be parent to itself
    $exception[] = $id;

    $options = Category::collection()->whereNotIn('id', $exception)
               ->getKeyPair('id', 'title');
    $options = [0 => '-SELECT-'] + $options;

    $this->_form->addSelectElement('parentCategoryId', $options, $value);
    $this->_form->getElement('parentCategoryId')->setLabel('Parent Category');
  }

  public function form()
  {
    return $this->_form;
  }
}
