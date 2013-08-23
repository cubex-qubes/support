<?php
/**
 * @author  chris.sparshott
 */

namespace Qubes\Support\Libs\Helpers\Menu;

use \Cubex\View\HtmlElement;

class Menu
{
  const TYPE_ARTICLES   = 'menu-articles';
  const TYPE_PRODUCTS   = 'menu-products';
  const TYPE_CATEGORIES = 'menu-categories';

  protected $_content;
  protected $_menuType;
  protected $_cssClass;
  protected $_titleText;

  public function __construct(
    array $content,
    $menuType = self::TYPE_ARTICLES,
    $cssClass = '',
    $titleText = ''
  )
  {
    $this->_content = $content;
    $this->_menuType = $menuType;
    $this->_cssClass = $cssClass;
    $this->_titleText = $titleText;

    $this->buildMenu();
  }

  protected function _generateCssClass()
  {
    $cssClass = $this->_menuType;
    if(!empty($this->_cssClass))
    {
      $cssClass .= ' ' . $this->_cssClass;
    }

    return $cssClass;
  }

  public function buildMenu()
  {
    $menu = new HtmlElement('span', ['class' => $this->_generateCssClass()]);
    $ul = new HtmlElement('ul');
    $heading = new HtmlElement('li', ['class' => 'heading'], $this->_titleText);

    $ul->nest($heading);

    foreach($this->_content as $item)
    {
      $li = new HtmlElement('li');

      $a = new HtmlElement(
        'a',
        [
        'href'  => $item['href']
        ]
      );

      $img = new HtmlElement(
        'span',
        [
        'class' => 'image ' . $item['icon']
        ]
      );

      $title = new HtmlElement(
        'span',
        [
        'class' => 'title'
        ],
        $item['title']
      );

      /**/
      $text = $item['text'];

      if($this->_menuType == self::TYPE_ARTICLES)
      {
        $length = 40;

        if(strlen($text) > $length) {
          $string = substr($text, 0, ($length - 3));
          $text = substr($text, 0, strrpos($string, ' ')) . '...';
        }
        else
        {
          $text .= '...';
        }
      }

      $text = new HtmlElement(
        'span',
        [
        'class' => 'text visible-desktop'
        ],
        $text
      );

      $a->nest($img);
      $a->nest($title);
      $a->nest($text);
      $li->nest($a);
      $ul->nest($li);
    }
    $menu->nest($ul);

    return $menu;
  }

  public function __toString()
  {
    return (string)$this->buildMenu();
  }
}
