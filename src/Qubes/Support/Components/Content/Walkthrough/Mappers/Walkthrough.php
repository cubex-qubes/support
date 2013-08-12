<?php
namespace Qubes\Support\Components\Content\Walkthrough\Mappers;


use Cubex\Mapper\Database\I18n\I18nRecordMapper;
use Cubex\Mapper\Database\RecordCollection;
use Qubes\Support\Components\Content\Walkthrough\Mappers\WalkthroughText;

class Walkthrough extends I18nRecordMapper
{
  public $categoryId;
  public $title;
  public $subTitle;
  public $description;
  public $slug;
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
   * @return WalkthroughStep[]|RecordCollection
   */
  public function getSteps()
  {
    /** @var WalkthroughStep[]|RecordCollection $steps */
    $steps = $this->hasMany(new WalkthroughStep, 'walkthroughId');
    $steps->setOrderBy('order');

    // todo this is a workaround: http://phabricator.cubex.io/T145
    foreach($steps as $step)
    {
      $step->reload();
    }

    return $steps;
  }

  /**
   * @param int $stepNumber
   *
   * @return WalkthroughStep
   * @throws \Exception#
   */
  public function getStep($stepNumber = 0)
  {
    foreach($this->getSteps() as $step)
    {
      if($step->order == $stepNumber)
      {
        return $step;
      }
    }

    return false;
  }



  public function getTextContainer()
  {
    return new WalkthroughText;
  }
}
