<?php
  /**
   * @package       Calendar
   * @class         AnnualCalendarDateReadView
   * @author        Jimmy CHARLEBOIS
   * @date          04-01-2007
   * @brief         
   */
  System::import( 'System.MVC.AbstractView' );

  class AnnualCalendarDateReadView extends AbstractView {
    public function __construct() {
      parent::__construct();
    }

    public function render() {
      $calendar_date =& $this->getModel();
      $day_labels = $calendar_date->getCalendar()->getDayLabels();

      $calendar_ctrl =& $calendar_date->getCalendar()->getController();

      return sprintf(
        '<a href="%s"><span class="day_number">%d</span> %s</a>',
        $calendar_ctrl->getDailyUrl( $calendar_date ),
        $calendar_date->day,
        $day_labels[ $calendar_date->day_number ]
      );
    }
  }
?>