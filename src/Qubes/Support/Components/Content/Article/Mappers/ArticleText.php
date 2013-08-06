<?php
namespace Qubes\Support\Components\Content\Article\Mappers;

use Cubex\Mapper\Database\I18n\TextContainer;

class ArticleText extends TextContainer
{
  /**
   * @datatype mediumtext
   */
  public $text;
}
