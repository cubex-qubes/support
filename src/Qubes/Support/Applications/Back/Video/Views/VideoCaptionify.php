<?php
/**
 * Author: oke.ugwu
 * Date: 22/08/13 13:29
 */

namespace Qubes\Support\Applications\Back\Video\Views;

use Cubex\Form\Form;
use Cubex\View\TemplatedViewModel;
use JayFrancis\Cubex\JWPlayer\JWPlayer;

class VideoCaptionify extends TemplatedViewModel
{
  protected $_form;
  protected $_importCaptionForm;
  private $_video;
  public $videoElementId;

  public function __construct($video)
  {
    $this->_video = $video;
    $this->requireJs('/jwplayer');
    $this->requireJs('captionControl');
    $this->requireCss('captionControl');
  }

  public function form()
  {
    if($this->_form !== null)
    {
      return $this->_form;
    }
    else
    {
      $formAction = '/admin/video/' . $this->_video->id()
      . '/caption/' . $this->_video->id() . '/edit';

      $this->_form = new Form('captionForm', $formAction);
      $this->_form->setDefaultElementTemplate('{{input}}');

      if($this->getCaptions()->hasMappers())
      {
        $i = 0;
        foreach($this->getCaptions() as $caption)
        {
          $id = $caption->id();
          $this->_form->addNumberElement(
            "caption[$id][start]",
            $caption->start_second
          );
          $this->_form->getElement("caption[$id][start]")
          ->setId("start-frame-$i")
          ->addAttribute('class', 'caption-time input-mini')
          ->addAttribute('step', 'any')
          ->addAttribute('min', 0);

          $this->_form->addNumberElement(
            "caption[$id][end]",
            $caption->end_second
          );
          $this->_form->getElement("caption[$id][end]")
          ->setId("end-frame-$i")
          ->addAttribute('class', 'caption-time input-mini')
          ->addAttribute('step', 'any')
          ->addAttribute('min', 0);

          $this->_form->addTextareaElement(
            "caption[$id][text]",
            $caption->text
          );
          $this->_form->getElement("caption[$id][text]")
          ->setId("caption-text-$i")
          ->addAttribute('style', 'width:96%')
          ->addAttribute('rows', 1);

          $i++;
        }
      }
      else
      {
        $this->_form->addNumberElement("_caption[0][start]", 0);
        $this->_form->getElement("_caption[0][start]")
        ->setId("start-frame-0")
        ->addAttribute('class', 'caption-time input-mini')
        ->addAttribute('step', 'any')
        ->addAttribute('min', 0);

        $this->_form->addNumberElement("_caption[0][end]", 0);
        $this->_form->getElement("_caption[0][end]")
        ->setId("end-frame-0")
        ->addAttribute('class', 'caption-time input-mini')
        ->addAttribute('step', 'any')
        ->addAttribute('min', 0);

        $this->_form->addTextareaElement("_caption[0][text]");
        $this->_form->getElement("_caption[0][text]")
        ->setId("caption-text-0")
        ->addAttribute('style', 'width:96%')
        ->addAttribute('rows', 1);
      }

      $this->_form->addSubmitElement('Update Captions');
      $this->_form->getElement('submit')
      ->addAttribute('class', 'btn btn-success');

      return $this->_form;
    }
  }

  public function getImportCaptionForm()
  {
    if($this->_importCaptionForm !== null)
    {
      return $this->_importCaptionForm;
    }
    else
    {
      $formAction = '/admin/video/' . $this->_video->id()
      . '/caption/' . $this->_video->id() . '/import';

      $this->_importCaptionForm = new Form('captionForm', $formAction);
      $this->_importCaptionForm->setDefaultElementTemplate('{{input}}');

      $this->_importCaptionForm->addTextareaElement("text");
      $this->_importCaptionForm->getElement("text")
      ->setRequired(true)
      ->addAttribute('style', 'width:98%')
      ->addAttribute('placeholder', 'Paste video transcript here')
      ->addAttribute('rows', 4);

      $this->_importCaptionForm->addSubmitElement('Captionify');
      $this->_importCaptionForm->getElement('submit')
      ->addAttribute('class', 'btn btn-success');

      return $this->_importCaptionForm;
    }
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

  public function getVideoHtml()
  {
    $player = new JWPlayer();
    $player->setHtml5PlayerUrl($this->getDispatchUrl('/jwplayer.html5.js'));
    $player->setFlashPlayerUrl($this->getDispatchUrl('/jwplayer.flash.swf'));
    $player->setWidth(480);
    $player->setVideoUrl($this->_video->url);

    if($this->_video->getCaptions())
    {
      $player->addCaptionConfig(
        sprintf('/video/captions/%d.vtt', $this->_video->id()),
        'On',
        true
      );
    }

    $this->videoElementId = $player->getElementId();

    return $player->getHtml();
  }
}
