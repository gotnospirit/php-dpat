<?php
  /**
   * @package     	Calendar
   * @class       	CalendarDateModel
   * @author      	Jimmy CHARLEBOIS
   * @date        	04-01-2007
   * @brief       	Mod�le pour une journ�e du calendrier
   */
  System::import( 'System.Interfaces.MVC.IModel' );

  class CalendarDateModel implements IModel {
    private $_calendar;
    private $_timestamp;

    private $_year;
    private $_month;
    private $_day;
    private $_hour;
    private $_minute;
    private $_second;

    private $_week;
    private $_day_number;

    public function __construct( CalendarModel &$calendar, $tstamp ) {
      $this->_calendar =& $calendar;
      if ( !is_numeric( $tstamp ) )
        $tstamp = strtotime( $tstamp );
      $this->_timestamp = $tstamp;

      $date = date( 'Y-m-d H:i:s', $this->_timestamp );
      $matches = array();
      preg_match( '/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $date, $matches );
      if ( 7 == count( $matches ) ) {
        $this->_year = (int)$matches[ 1 ];
        $this->_month = (int)$matches[ 2 ];
        $this->_day = (int)$matches[ 3 ];
        $this->_hour = (int)$matches[ 4 ];
        $this->_minute = (int)$matches[ 5 ];
        $this->_second = (int)$matches[ 6 ];

        $this->_week = (int)date( 'W', $this->_timestamp );
        $this->_day_number = (int)date( 'w', $this->_timestamp );
      }
    }

    /**
     * @brief   Retourne le calendrier associ� � la date
     * @return  CalendarModel
     */
    public function &getCalendar() {
      return $this->_calendar;
    }

    /**
     * @brief   Retourne la date format�e
     * @param   $format   string    cha�ne repr�sentant le format de la date
     * @see     http://www.php.net/date
     */
    public function toDate( $format = 'Y-m-d' ) {
      return date( $format, $this->_timestamp );
    }

    public function __toString() {
      return (string)$this->_timestamp;
    }

    /**
     * @brief   Getter g�n�rique pour exposer les propri�t�s suivantes :
     *  - year        Ann�e courante
     *  - month       Num�ro du mois courant
     *  - day         Num�ro du jour courant
     *  - hour        Heure courante
     *  - minute      Minutes
     *  - second      Secondes
     *  - week        Num�ro de la semaine en cours
     *  - day_number  Num�ro du jour de la semaine
     * @return  integer
     */
    public function __get( $varName ) {
      switch( $varName ) {
        case 'year':
        case 'month':
        case 'day':
        case 'hour':
        case 'minute':
        case 'second':
        case 'week':
        case 'day_number':
          return $this->{'_'.$varName};
          break;       
      }
    }
  }
?>