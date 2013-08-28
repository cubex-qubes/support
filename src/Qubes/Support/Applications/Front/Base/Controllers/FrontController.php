<?php
namespace Qubes\Support\Applications\Front\Base\Controllers;

use Cubex\Core\Controllers\WebpageController;
use Cubex\Foundation\Container;
use Cubex\Foundation\IRenderable;
use Qubes\Support\Applications\Front\Base\BaseFrontApp;
use Qubes\Support\Applications\Front\Base\Views\FrontBreadcrumbView;
use Qubes\Support\Applications\Front\Base\Views\FrontHeader;
use Qubes\Support\Applications\Front\Base\Views\FrontView;
use Cubex\View\Templates\Errors\Error404;
use Cubex\Mapper\Database\RecordMapper;
use Qubes\Support\Components\Content\Walkthrough\Mappers\WalkthroughStep;

abstract class FrontController extends WebpageController
{

  public function preProcess()
  {
    $this->_addProjectResources();
    $this->_nestSections();
    $this->requireCss('/main', __NAMESPACE__);
  }

  public function preRender()
  {
    $this->tryNest('header', $this->getHeader());
  }

  public function getProjectBaseUri()
  {
    $config = Container::config()->get('project');
    if(isset($config->base_uri))
    {
      return $config->base_uri;
    }

    return '/';
  }

  public function getUrl(RecordMapper $entity)
  {
    $parts = [];

    if($entity instanceof WalkthroughStep)
    {
      return $this->_getWalkthroughStepUrl($entity);
    }

    $parts[] = strtolower(class_shortname($entity));
    $slug    = isset($entity->slug) ? sprintf('-%s', $entity->slug) : '';
    $parts[] = sprintf(
      '%d%s',
      $entity->id(),
      $slug
    );

    return $this->getProjectBaseUri() . implode('/', $parts);
  }

  private function _getWalkthroughStepUrl(WalkthroughStep $walkthroughStep)
  {
    $walkthrough = $walkthroughStep->getWalkthrough();

    $url = sprintf(
      '%s/%d-%s',
      $this->getUrl($walkthrough),
      $walkthroughStep->id(),
      $walkthroughStep->slug
    );

    return $url;
  }

  public function getHeader()
  {
    return $this->getView('FrontHeader', 'Base');
  }

  /**
   * Check for an override then return the view object
   *
   * @param      $className
   * @param null $applicationName
   *
   * @throws \Exception
   * @return FrontView
   */
  public function getView($className, $applicationName = null)
  {
    if(!$applicationName)
    {
      $applicationName = $this->getApplicationName();
    }

    $class = sprintf(
      '%s\Applications\Front\%s\Views\%s',
      $this->getProjectNamespace(),
      $applicationName,
      $className
    );

    if(class_exists($class))
    {
      return $this->createView(new $class());
    }

    $class = sprintf(
      'Qubes\Support\Applications\Front\%s\Views\%s',
      $applicationName,
      $className
    );

    if(!class_exists($class))
    {
      throw new \Exception($class . ' Not Found');
    }

    return $this->createView(new $class());
  }

  /**
   * @return string
   */
  public function getApplicationName()
  {
    return $this->getApplication()->getApplicationName();
  }

  /**
   * @return BaseFrontApp
   */
  public function getApplication()
  {
    return $this->application();
  }

  /**
   * @return \Qubes\Support\Project
   */
  public function getProject()
  {
    return $this->getApplication()->getProject();
  }

  /**
   * Gets the namespace for the project
   *
   * @return mixed|string
   */
  public function getProjectNamespace()
  {
    return $this->getProject()->getNamespace();
  }

  /**
   * Nest the main sections
   *
   * @return $this
   */
  private function _nestSections()
  {
    $config = Container::config()->get('project');
    if($config->extended)
    {
      $namespace = sprintf(
        '%s\Applications\Front\Base\Views\Section',
        $config->namespace
      );

      $header = sprintf('%s\Header', $namespace);
      if(class_exists($header))
      {
        $this->nest("header", new $header);
      }

      $footer = sprintf('%s\Footer', $namespace);
      if(class_exists($footer))
      {
        $this->nest("footer", new $footer);
      }
    }

    return $this;
  }

  /**
   * Add base project resources, JD, CSS etc
   *
   * @return $this
   */
  private function _addProjectResources()
  {
    $config = Container::config()->get('project');

    foreach($config->css as $file)
    {
      $this->requireCss($file);
    }

    foreach($config->js as $file)
    {
      $this->requireJs($file);
    }

    return $this;
  }

  public function renderNotFound()
  {
    $this->webpage()->setStatusCode("404");

    return new Error404();
  }

  public function defaultAction()
  {
    return "notFound";
  }

  /**
   * Set the view, as the sidebars will be determined by the different views
   *
   * @param IRenderable $view
   */
  public function setView(IRenderable $view)
  {
    if($view instanceof FrontView)
    {
      foreach($this->getProject()->getNestedViews() as $nestedViewName)
      {
        $getNestedView = sprintf('get%s', $nestedViewName);
        $nestedView = $view->$getNestedView();
        if($nestedView !== null && $nestedView instanceof IRenderable)
        {
          $this->nest($nestedViewName, $nestedView);
        }
      }

      $breadcrumbs = $view->getBreadcrumbs();
      if($breadcrumbs !== null
        //&& $breadcrumbs instanceof IRenderable
      )
      {
        $breadcrumb = new FrontBreadcrumbView($breadcrumbs);

        $this->renderBefore('content', $breadcrumb);
      }
    }
    $this->nest("content", $view);

    return $view;
  }
}
