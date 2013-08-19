<?php
/**
 * Author: oke.ugwu
 * Date: 16/08/13 11:54
 */
namespace Qubes\Support\Components\Helpers;

use Cubex\Foundation\Container;
use Cubex\Mapper\Database\RecordMapper;

trait ViewOptionsTrait
{
  public function getViewOptions()
  {
    if($this instanceof RecordMapper)
    {
      $viewOptions = [];
      $project     = Container::config()->get('project');
      $mapperName  = class_shortname($this);
      $viewPath    = "/Applications/Front/" . $mapperName . "/Views/";

      $viewDirs                      = [];
      $extended                      = [];
      $viewDirs[$project->namespace] = $project->path . $viewPath;
      $extended[$project->namespace] = false;
      if($project->extended)
      {
        $viewDirs[$project->extended_namespace] = $project->extended_path . $viewPath;
        $extended[$project->extended_namespace] = true;
      }

      foreach($viewDirs as $namespace => $viewDir)
      {
        if(file_exists($viewDir))
        {
          $files = glob($viewDir . '*.php');
          foreach($files as $file)
          {
            $pathInfo      = pathinfo($file);
            $className     = basename($pathInfo['filename']);
            $fullClassName = $namespace . '\\Applications\\Front\\' .
              $mapperName . '\\Views\\' . $className;

            if(isset($extended[$namespace]) && $extended[$namespace])
            {
              $className = $className . ' [Default]';
            }

            $viewOptions[$fullClassName] = $className;
          }
        }
      }

      if(empty($viewOptions))
      {
        throw new \Exception('No Views found');
      }

      return $viewOptions;
    }
    else
    {
      throw new \Exception('ViewOptionTrait can only be used by a RecordMapper');
    }
  }
}
