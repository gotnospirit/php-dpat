<?php
  /**
   * @package       Calendar
   * @class         AnnualCalendarReadView
   * @author        Jimmy CHARLEBOIS
   * @date          04-01-2007
   * @brief         
   */
  System::import( 'System.MVC.AbstractView' );
  System::import( 'System.Calendar.Views.Read.AnnualCalendarDateReadView' );

  class AnnualCalendarReadView extends AbstractView {
    public function __construct() {
      parent::__construct();
    }

    public function render() {
      $calendar =& $this->getModel();

      $bounds = $calendar->getBounds();

      $days = $calendar->getDays( $bounds[ 'low' ], $bounds[ 'high' ] );
//      system::export( $days );

      $month_labels = $calendar->getMonthLabels();

      $html = '<div class="calendar">'.System::crlf;
      if ( count( $days ) > 0 ) {
        $html .= '<table border="1" cellspacing="0" cellpadding="0" class="annual_view">'.System::crlf
          . '<thead>'.System::crlf
          . '<tr>'.System::crlf;
        foreach( $month_labels AS $idx => $label )
          $html .= '<th>'.htmlspecialchars( $label ).'</th>'.System::crlf;
        $html .= '</tr>'.System::crlf
          . '</thead>'.System::crlf
          . '<tbody>'.System::crlf
          . '<tr>'.System::crlf;
        $month = null;
        foreach( $days AS $idx => $calendar_date ) {
          $dateView =& new AnnualCalendarDateReadView();
          $dateView->setModel( $days[ $idx ] );

          if ( $month != $calendar_date->month ) {
            if ( !is_null( $month ) )
              $html .= '</ul></td>'.System::crlf;
            $html .= '<td><ul>'.System::crlf;
          }
          $html .= '<li>'.$dateView->render().'</li>'.System::crlf;

          $month = $calendar_date->month;
        }
        $html .= '</ul></td></tr>'.System::crlf;
        $html .= '</tbody>'.System::crlf
          . '</table>'.System::crlf;
      }
      $html .= '</div>';
      return $html;
    }
  }
?>