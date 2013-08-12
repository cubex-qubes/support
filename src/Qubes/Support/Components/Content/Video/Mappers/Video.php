<?php
namespace Qubes\Support\Components\Content\Video\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Cubex\Mapper\Database\RecordCollection;

/**
 * @method static \Qubes\Support\Components\Content\Video\Mappers\Video[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class Video extends I18nRecordMapper
{
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
  public $order;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle'
    );
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
}
