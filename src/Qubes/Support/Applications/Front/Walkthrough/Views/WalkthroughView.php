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

  public function getNextStepUrl()
  {
    $currentStep = $this->getCurrentStep();

    // todo use ArrayItterator here
    $steps = $this->getWalkthrough()->getSteps();
    foreach($steps as $key => $step)
    {
      if($step->id() == $currentStep->id())
      {
        $nextKey = $key + 1;
        if(isset($steps[$nextKey]))
        {
          $nextStep = $steps[$nextKey];
          return sprintf('%d-%s', $nextKey, $nextStep->slug);
        }
      }
    }

    return false;
  }

  public function getPreviousStepUrl()
  {
    $currentStep = $this->getCurrentStep();

    // todo use ArrayItterator here
    $steps = $this->getWalkthrough()->getSteps();
    foreach($steps as $key => $step)
    {
      if($step->id() == $currentStep->id())
      {
        $previousKey = $key - 1;
        if(isset($steps[$previousKey]))
        {
          $previousStep = $steps[$previousKey];
          return sprintf('%d-%s', $previousKey, $previousStep->slug);
        }
      }
    }

    return false;
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

  public function getSidebar()
  {
    /** @var WalkthroughSidebar $sidebar */
    $sidebar = $this->getView('WalkthroughSidebar');
    $sidebar->setWalkthrough($this->getWalkthrough());

    return $sidebar;
  }
}
