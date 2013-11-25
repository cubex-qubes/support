<?php
/**
 * Author: oke.ugwu
 * Date: 23/08/13 16:39
 */

namespace Qubes\Support\Applications\Back\Category\Forms;

use Cubex\Dispatch\Utils\RequireTrait;
use Cubex\Form\FormElement;
use Cubex\Form\FormElementRender;
use Cubex\View\HtmlElement;
use Cubex\View\Partial;
use Cubex\View\RenderGroup;
use Qubes\Support\Libs\Helpers\Icons\Icon16;

class IconPicker extends FormElementRender
{
  use RequireTrait;

  protected $_element;
  protected $_template;
  protected $_css = '/iconPicker';
  protected $_js = '/iconPicker';

  public function __construct(FormElement $element, $template = null)
  {
    $this->_element = $element;
    if($template == null)
    {
      $this->_template = '{{label}}<div class="input-append">{{input}}
         <button class="btn iconpicker" type="button"><i class="icon-th"></i></button>
       </div>';
    }
    else
    {
      $this->_template = $template;
    }
  }

  public function render()
  {
    $type = $this->_element->type();
    $out  = str_replace(
      '{{input}}',
      $this->renderInput($type),
      $this->_template
    );
    $out  = str_replace('{{label}}', $this->renderLabel(), $out);

    $out .= $this->buildIconPicker();
    $out = '<div data-picker-id="' . $this->_element->id()
    . '" class="iconpicker-wrapper">' . $out . '</div>';

    $this->requireCss($this->_css);
    $this->requireJs($this->_js);
    return $out;
  }

  public function buildIconPicker()
  {
    $icons = new Partial('<li class="%s"></li>');
    foreach($this->_getIcons() as $icon)
    {
      $icons->addElement($icon);
    }

    $iconList = new HtmlElement('ul', ['class' => 'iconlist'], $icons);
    return new HtmlElement('div', ['class' => 'iconpicker-popup'], $iconList);
  }

  public function __toString()
  {
    return $this->render();
  }

  public function setCss($css)
  {
    $this->_css = $css;
  }

  public function setJs($js)
  {
    $this->_js = $js;
  }

  private function _getIcons()
  {
    $icons = new Icon16();
    return $icons->getConstList();
  }
}
