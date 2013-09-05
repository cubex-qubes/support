<?php
/**
 * Author: oke.ugwu
 * Date: 05/09/13 13:24
 */

namespace Qubes\Support\Applications\Back\Video\Forms;

use Cubex\Form\Form;
use Cubex\Mapper\Database\RecordMapper;
use Qubes\Support\Components\Content\Category\Mappers\Category;
use Qubes\Support\Components\Content\Video\Mappers\Video;

class VideoForm extends Form
{
  public function __construct($name)
  {
    parent::__construct($name);
    $this->setDefaultElementTemplate('<p>{{label}}{{input}}</p>');
  }

  public function bindMapper(RecordMapper $mapper)
  {
    if($mapper instanceof Video)
    {
      parent::bindMapper($mapper);

      $this->getElement('title')->addAttribute('class', 'input-xxlarge');
      $this->getElement('SubTitle')->addAttribute('class', 'input-xxlarge');
      $this->getElement('slug')->addAttribute('class', 'input-xxlarge');
      $this->getElement('imageUrl')->addAttribute('class', 'input-xxlarge');
      $this->getElement('submit')->addAttribute('class', 'btn btn-success');
      $this->getElement('url')
      ->setLabel('Video URL')
      ->addAttribute('class', 'input-xxlarge');

      $options = Category::collection()->getKeyPair('id', 'title');
      $this->addSelectElement(
        'categoryId',
        $options,
        $mapper->categoryId
      );
      $this->getElement('categoryId')->setLabel('Category');
    }
    else
    {
      throw new \Exception('Only Video Mapper can be bound to this form');
    }
  }
}
