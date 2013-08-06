<?php
namespace Qubes\Support\Applications\Front\Base\Views;

use Cubex\Foundation\Container;
use Cubex\View\TemplatedViewModel;
use Cubex\Foundation\IRenderable;

abstract class FrontView extends TemplatedViewModel
{

  /**
   * Override this Views's Template directory
   *
   * @param $directory
   *
   * @return $this
   */
  public function setTemplateDirectory($directory)
  {
    $config = Container::config()->get('project');

    if($config->extended)
    {
      $fullClassName  = get_called_class();
      $classNameSplit = explode("\\", $fullClassName);
      $className      = end($classNameSplit);

      $templatePath = str_replace(
        array("Qubes\\Support", "\\Views\\", $className),
        array($config->path, "\\Templates", ""),
        $fullClassName
      );

      if(file_exists(sprintf('%s/%s.phtml', $templatePath, $className)))
        $directory = $templatePath;
    }

    $this->_baseDirectory = $directory;

    return $this;
  }

  /**
   * Override the current View's Template file
   *
   * @param        $file
   * @param string $ext
   *
   * @return $this
   */
  public function setTemplateFile($file, $ext = 'phtml')
  {
    $this->_filePath = $file;
    $this->_fileExt  = $ext;

    return $this;
  }

  /**
   * Get the Sidebar nested view
   *
   * @return null|IRenderable
   */
  public function getSidebar()
  {
    return null;
  }
}
