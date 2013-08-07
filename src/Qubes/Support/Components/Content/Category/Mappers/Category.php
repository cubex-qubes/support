<?php
namespace Qubes\Support\Components\Content\Category\Mappers;

use Cubex\Mapper\Database\I18n\I18nRecordMapper;

/**
 * @method static \Qubes\Support\Components\Content\Category\Mappers\Category[]|\Cubex\Mapper\Database\RecordCollection collection
 */
class Category extends I18nRecordMapper
{
  public $parentCategoryId;
  public $title;
  public $subTitle;
  public $description;
  public $view;
  /**
   * @datatype int(11)
   */
  public $order;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle',
      'description'
    );
  }

  /**
   * @return bool|\Cubex\Mapper\Database\RecordMapper|static
   */
  public function getParentCategory()
  {
    return $this->belongsTo(new Category(), 'parentCategoryId');
  }

  /**
   * @return \Cubex\Mapper\Database\RecordMapper|null
   */
  public function getChildCategories()
  {
    return $this->hasMany(new Category(), 'parentCategoryId');
  }

  /**
   * @return CategoryText
   */
  public function getTextContainer()
  {
    return new CategoryText;
  }
}
