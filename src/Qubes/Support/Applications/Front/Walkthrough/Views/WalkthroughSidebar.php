<?php
namespace Qubes\Support\Applications\Front\Walkthrough\Views;

use Cubex\View\TemplatedViewModel;
use Qubes\Bootstrap\Nav;
use Qubes\Bootstrap\NavItem;
use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Category\Mappers\Category;
use Qubes\Support\Components\Content\Walkthrough\Mappers\Walkthrough;

class WalkthroughSidebar extends FrontView
{
  /** @var Walkthrough */
  private $_walkthrough;

  /**
   * @param Walkthrough $walkthrough
   *
   * @return $this
   */
  public function setWalkthrough(Walkthrough $walkthrough)
  {
    $this->_walkthrough = $walkthrough;

    return $this;
  }

  /**
   * @throws \Exception
   * @return Walkthrough
   */
  public function getWalkthrough()
  {
    if(!isset($this->_walkthrough))
    {
      throw new \Exception('Walkthrough not set');
    }

    return $this->_walkthrough;
  }

  /**
   * @return string
   */
  public function render()
  {
    $menu = new Nav(Nav::NAV_DEFAULT);

    $walkthrough = $this->getWalkthrough();

    foreach($walkthrough->getSteps() as $step)
    {
      $state = NavItem::STATE_NONE;

      $item = new NavItem(
        sprintf(
          '<a href="%s">%s</a>',
          $this->getUrl($step),
          $step->title
        ),
        $state
      );

      $menu->addItem($item);
    }

    return $menu->render();
  }
}
