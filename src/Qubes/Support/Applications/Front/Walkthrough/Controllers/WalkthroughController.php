<?php
namespace Qubes\Support\Applications\Front\Walkthrough\Controllers;

use Qubes\Support\Applications\Front\Walkthrough\Views\WalkthroughView;
use Qubes\Support\Applications\Front\Base\Controllers\FrontController;
use Qubes\Support\Components\Content\Walkthrough\Mappers\Walkthrough;

class WalkthroughController extends FrontController
{
  /**
   * Render an Walkthrough
   *
   * @param $id
   * @param $slug
   * @param $stepNumber
   * @param $stepSlug
   *
   * @return WalkthroughView
   */
  public function renderWalkthrough($id, $slug, $stepNumber, $stepSlug)
  {
    $walkthrough = new Walkthrough($id);
    if(!$walkthrough->exists())
    {
      return $this->renderNotFound();
    }

    $step = $walkthrough->getStep($stepNumber);
    if(!$step)
    {
      return $this->renderNotFound();
    }

    /** @var WalkthroughView $view */
    $view = $this->getMapperView($walkthrough, 'WalkthroughView');
    $view->setWalkthrough($walkthrough);
    $view->setCurrentStep($step);

    // Set the title
    $view->setTitle(sprintf('%s - %s', $walkthrough->title, $step->title));

    return $this->setView($view);
  }

  /**
   * @return array|\Cubex\Routing\IRoute[]
   */
  public function getRoutes()
  {
    return [
      '/walkthrough/:id@num:slug@all/:stepNumber@num:stepSlug@all' => 'walkthrough',
    ];
  }
}
