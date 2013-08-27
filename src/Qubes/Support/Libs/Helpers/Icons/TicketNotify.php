<?php
/**
 * @author  chris.sparshott
 */

namespace Support\Libs\Helpers\Icons;

use Cubex\View\HtmlElement;

class TicketNotify
{
  protected $_count;

  /**
   * @param int $ticketCount
   */
  public function __construct($ticketCount)
  {
    $this->_count = $ticketCount;
    $this->_buildElement();
  }

  /**
   * @return HtmlElement
   */
  protected function _buildElement()
  {
    $p = new HtmlElement('p', ['class' => 'supportTicket notify']);
    $i = new HtmlElement('i', ['class' => Icon32::ENVELOPE]);
    $span = new HtmlElement('span', ['class' => 'count'], $this->_count);

    $p->nest($i);
    $p->nest($span);

    return $p;
  }

  public function __toString()
  {
    return (string)$this->_buildElement();
  }
}
