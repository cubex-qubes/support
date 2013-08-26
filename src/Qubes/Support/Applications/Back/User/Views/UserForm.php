<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:25
 */

namespace Qubes\Support\Applications\Back\User\Views;

use Cubex\View\TemplatedViewModel;
use Qubes\Support\Applications\Back\Category\Forms\IconPicker;
use Qubes\Support\Components\Content\Category\Mappers\Category;

class UserForm extends TemplatedViewModel
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
  }

  public function form()
  {
    return $this->_form;
  }
}
