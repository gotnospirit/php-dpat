<?php
  /**
   * @package       Calendar
   * @class         DailyCalendarReadView
   * @author        Jimmy CHARLEBOIS
   * @date          11-01-2007
   * @brief         
   */
  System::import( 'System.MVC.AbstractView' );

  class DailyCalendarReadView extends AbstractView {
    public function __construct() {
      parent::__construct();
    }

    public function render() {
      $calendar =& $this->getModel();
      $selected_date = $calendar->getCurrentDate();

      $calendar_ctrl =& $calendar->getController();

      $html = '<div class="calendar">'.System::crlf;
      if ( !is_null( $selected_date ) ) {
        $html .= '<table border="1" cellspacing="0" cellpadding="0" class="daily_view">'.System::crlf
          . '<thead>'.System::crlf
          . '<tr>'.System::crlf
          . '<th>'.htmlspecialchars( $selected_date->toDate( 'd/m/Y' ) ).'</th>'.System::crlf
          . '</tr>'.System::crlf
          . '</thead>'.System::crlf
          . '<tbody>'.System::crlf;
        for( $i=0; $i<24; $i++ ) {
          $html .= '<tr><td><span class="hour_number">'.$i.'h</span> '
            . '<a href="#">edit</a></td></tr>'.System::crlf
            ;
        }
        $html .= '</tbody>'.System::crlf
          . '</table>'.System::crlf;
      }
      $html .= '</div>';
      return $html;
    }
  }
?>