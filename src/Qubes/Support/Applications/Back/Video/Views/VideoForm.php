<?php
/**
 * Author: oke.ugwu
 * Date: 31/07/13 10:25
 */

namespace Qubes\Support\Applications\Back\Video\Views;

use Cubex\Form\Form;
use Cubex\View\TemplatedViewModel;
use Qubes\Support\Components\Content\Video\Mappers\Video;

class VideoForm extends TemplatedViewModel
{
  public $heading;
  protected $_form;
  protected $_video;

  /**
   * @param string            $heading
   * @param  \Cubex\Form\Form $form
   */
  public function __construct($heading, $form)
  {
    $this->heading = $heading;
    $this->_form   = $form;

    if($form->getMapper() instanceof Video)
    {
      $this->_video = $form->getMapper();
    }
  }

  public function form()
  {
    return $this->_form;
  }

  public function getVideo()
  {
    return $this->_video;
  }

  public function getCaptions()
  {
    if($this->_video->exists())
    {
      return $this->_video->getCaptions();
    }

    return null;
  }


}
