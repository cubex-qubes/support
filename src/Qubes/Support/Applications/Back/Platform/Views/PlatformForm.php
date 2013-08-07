<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:25
 */

namespace Qubes\Support\Applications\Back\Platform\Views;

use Cubex\View\TemplatedViewModel;
use Qubes\Support\Components\Content\Category\Mappers\Category;

class PlatformForm extends TemplatedViewModel
{
  public $heading;
  protected $_form;

  /**
   * @param string $heading
   * @param  \Cubex\Form\Form $form
   */
  public function __construct($heading, $form)
  {
    $this->heading = $heading;
    $this->_form   = $form;
    $this->_form->getElement('name')->setRequired(true);
  }

  public function form()
  {
    return $this->_form;
  }
}
