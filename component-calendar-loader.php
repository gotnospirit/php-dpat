<?php
  /**
   * @author      	Jimmy CHARLEBOIS
   * @date        	04-01-2007
   * @brief       	Exemple de chargement d'un calendrier
   */
  require 'c.system.php';
  require 'Timer.php';

  System::import( 'System.Context.HttpContext' );
  System::import( 'System.Calendar.Models.CalendarModel' );
  System::import( 'System.Calendar.Controllers.StandardCalendarController' );

  $context =& new HttpContext();

  $timer = new Timer();
  $model =& new CalendarModel( time() );
  $model->init();

  $model->setMonthLabels(
    array(
      1 => 'Janvier',
      2 => 'Février',
      3 => 'Mars',
      4 => 'Avril',
      5 => 'Mai',
      6 => 'Juin',
      7 => 'Juillet',
      8 => 'Août',
      9 => 'Septembre',
      10 => 'Octobre',
      11 => 'Novembre',
      12 => 'Décembre'
    )
  );
  $model->setDayLabels(
    array(
      0 => 'Dimanche',
      1 => 'Lundi',
      2 => 'Mardi',
      3 => 'Mercredi',
      4 => 'Jeudi',
      5 => 'Vendredi',
      6 => 'Samedi'
    )
  );

  $calendar =& new StandardCalendarController( $context, $model );
  $calendar->process();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Chargeur de Calendrier</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="StyleSheet" type="text/css" href="calendar.css" />
</head>
<body>
<?php
  $view =& $calendar->getView();
  if ( !is_null( $view ) )
    $view->display();

  echo sprintf(
    '<div style="border: 1px solid red; margin: 5px; padding: 4px; font-family: Verdana; font-size: 10px;">en %s</div>',
    $timer->ReturnTimer()
  );
?>
</body>
</html>