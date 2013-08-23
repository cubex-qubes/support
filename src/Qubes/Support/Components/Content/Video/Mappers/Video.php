<?php
namespace Qubes\Support\Components\Content\Video\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Cubex\Mapper\Database\RecordCollection;
use Qubes\Support\Components\Content\Category\Mappers\Category;
use Qubes\Support\Components\Helpers\ViewOptionsTrait;

/**
 * @method static \Qubes\Support\Components\Content\Video\Mappers\Video[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class Video extends I18nRecordMapper
{
  use ViewOptionsTrait;

  public $categoryId;
  public $title;
  public $subTitle;
  public $url;
  public $imageUrl;
  public $view;
  public $slug;
  /**
   * @datatype int(11)
   */
  public $order = 0;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle'
    );

    $this->_setRequired('title');
    $this->_setRequired('subTitle');
    $this->_setRequired('url');
    $this->_setRequired('imageUrl');
    $this->_setRequired('order');
  }

  /**
   * @return VideoCaption[]
   */
  public function getCaptions()
  {
    /** @var VideoCaption[]|RecordCollection $captions */
    $captions = $this->hasMany(new VideoCaption);
    $captions->setOrderBy('start_second');

    // todo this is a workaround: http://phabricator.cubex.io/T145
    foreach($captions as $caption)
    {
      $caption->reload();
    }

    return $captions;
  }

  /**
   * @return VideoText
   */
  public function getTextContainer()
  {
    return new VideoText;
  }

  public function getCategory()
  {
    return $this->belongsTo(new Category(), 'categoryId');
  }

  public function views()
  {
    return $this->getViewOptions();
  }
}
