<?php
/**
 * Article Text Container
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Article;

use Cubex\Mapper\Database\I18n\TextContainer;

class ArticleTextContainer extends TextContainer
{
  /**
   * @datatype mediumtext
   */
  public $text;
}
