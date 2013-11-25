<?php
namespace Qubes\Support\Components\Content\Category\Mappers;

use Cubex\Data\Validator\Validator;
use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Qubes\Support\Components\Helpers\ViewOptionsTrait;
use Qubes\Support\Libs\Helpers\Icons\Icon16;

class Category extends I18nRecordMapper
{
  use ViewOptionsTrait;

  public $parentCategoryId;
  public $title;
  public $subTitle;
  public $description;
  public $view;
  public $slug;
  public $icon;
  /**
   * @datatype int(11)
   */
  public $order = 0;

  protected function _configure()
  {
    $this->_addTranslationAttribute(
      'title',
      'subTitle',
      'description'
    );

    $this->_setRequired('order', true);
    $this->_addValidator('order', Validator::VALIDATE_INT);
    $this->_addValidator('order', Validator::VALIDATE_NOTEMPTY);
  }

  /**
   * @return \Cubex\Mapper\Database\RecordMapper[]|Category[]
   */
  public function getSiblingCategories()
  {
    $categories = Category::collection();

    return $categories->whereEq('parent_category_id', $this->parentCategoryId);
  }

  /**
   * @return \Cubex\Mapper\Database\RecordMapper|Category
   */
  public function getParentCategory()
  {
    return $this->belongsTo(new Category(), 'parent_category_id');
  }

  /**
   * @return \Cubex\Mapper\Database\RecordMapper[]|Category[]
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

  public function views()
  {
    return $this->getViewOptions();
  }

  public function icons()
  {
    //return new Icon16();
  }
}
