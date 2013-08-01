<?php
/**
 * Video Text Container
 *
 * @author Jay Francis <jay.francis@jdiuk.com>
 */

namespace Qubes\Support\Components\Content\Video\Mappers;

use Cubex\Mapper\Database\I18n\TextContainer;

class VideoText extends TextContainer
{
  /**
   * @datatype mediumtext
   */
  public $text;
}
