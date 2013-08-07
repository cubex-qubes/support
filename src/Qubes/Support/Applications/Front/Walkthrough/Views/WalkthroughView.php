<?php
namespace Qubes\Support\Applications\Front\Walkthrough\Views;

use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Qubes\Support\Components\Content\Article\Mappers\Article;
use Qubes\Support\Components\Content\Walkthrough\Mappers\Walkthrough;
use Qubes\Support\Components\Content\Walkthrough\Mappers\WalkthroughStep;

class WalkthroughView extends FrontView
{
  /** @var Walkthrough */
  private $_walkthrough;
  /** @var WalkthroughStep */
  private $_step;

  public function __construct()
  {
    $this->setTitle($this->t("Walkthrough"));
  }

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

  public function setCurrentStep(WalkthroughStep $step)
  {
    $this->_step = $step;

    return $this;
  }

  /**
   * @throws \Exception
   * @return WalkthroughStep
   */
  public function getCurrentStep()
  {
    if(!isset($this->_step))
    {
      throw new \Exception('Step not set');
    }

    return $this->_step;
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
}
