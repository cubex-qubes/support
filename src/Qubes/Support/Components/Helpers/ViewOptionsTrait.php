<?php
/**
 * Author: oke.ugwu
 * Date: 16/08/13 11:54
 */
namespace Qubes\Support\Components\Helpers;

use Cubex\Foundation\Container;

trait ViewOptionsTrait
{

  public function getViewOptions()
  {
    $viewOptions = [];
    $projectBase = Container::config()->get('_cubex_')->getStr('project_base');
    $viewPath    = "/Qubes/Support/Applications/Front/" . class_shortname(
        $this
      ) . "/Views/";
    $viewDir     = $projectBase . $viewPath;

    $files = glob($viewDir . '*.php');
    foreach($files as $file)
    {
      $pathInfo = pathinfo($file);
      $fileName  = basename($pathInfo['filename']);

      $fullClassName = str_replace('/', '\\', $viewPath) . $fileName;

      $viewOptions[$fullClassName] = $fileName;
    }

    return $viewOptions;
  }
}
