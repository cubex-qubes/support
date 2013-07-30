<?php
namespace Qubes\Support\Components\Content\Category\Mappers;
/**
 * Category Mapper
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */
use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Content\Category\CategoryTextContainer;

class Category extends I18nRecordMapper
{
  public $parentCategoryId;
  public $title;
  public $subTitle;
  public $description;

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
   * @return CategoryTextContainer
   */
  public function getTextContainer()
  {
    return new CategoryTextContainer();
  }
}
