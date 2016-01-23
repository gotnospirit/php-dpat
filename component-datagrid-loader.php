<?php
  require 'c.system.php';
  require 'Timer.php';
$genTimer = new Timer();

  System::import( 'System.Context.HttpContext' );
  System::import( 'System.DataGrid.DataSources.DataGridSource' );
  System::import( 'System.DataSource.Expressions.XpathExpression' );
  System::import( 'System.DataSource.Expressions.DbmsExpression' );
  System::import( 'System.DataGrid.Controller.DataGridController' );
  System::import( 'System.SqlBuilder.SqlBuilder' );

  $context =& new HttpContext();

  $timer =& new Timer();
  $xmlDataSource =& DataGridSource::createNew( 'xml://datagrid.xml/' );
  $xmlDataGrid =& $xmlDataSource->getDataGrid( new XpathExpression( '//datagrid' ) );

  $dgController1 =& new DataGridController( $context, $xmlDataGrid );
  $dgController1->process();
  $xmlTime = $timer->ReturnTimer();

  $timer =& new Timer();
  $dbDataSource =& DataGridSource::createNew( 'mysql://mysql:user@localhost.DPat/' );

  $sql =& new sqlBuilder();
  $aliasA = $sql->aliasTable( 'DataGrid', 'A' );
  $aliasB = $sql->aliasTable( 'DataGridRow', 'B' );
  $aliasC = $sql->aliasTable( 'DataGridColumn', 'C' );
  $sql->get( $aliasA, 'id', 'datagrid_id' );
  $sql->get( $aliasA, 'title', 'datagrid_title' );
  $sql->get( $aliasB, 'id', 'datagridrow_id' );
  $sql->get( $aliasC, 'id', 'datagridcolumn_id' );
  $sql->get( $aliasC, 'value', 'datagridcolumn_value' );
  $sql->joinTable( $aliasA, 'id', $aliasB, 'datagrid_id', '=', sqlBuilder::InnerJoin );
  $sql->joinTable( $aliasB, 'id', $aliasC, 'datagridrow_id', '=', sqlBuilder::InnerJoin );
  $request = $sql->select();
//  $request = 'SELECT A.id AS datagrid_id, A.title AS datagrid_title, B.id AS datagridrow_id, C.id AS datagridcolumn_id, C.value AS datagridcolumn_value FROM DataGrid AS A INNER JOIN DataGridRow AS B ON ( A.id = B.datagrid_id ) INNER JOIN DataGridColumn AS C ON ( B.id = C.datagridrow_id )';
  $dbDataGrid =& $dbDataSource->getDataGrid( new DbmsExpression( $request ) );

  $dgController2 =& new DataGridController( $context, $dbDataGrid );
  $dgController2->process();
  $dbTime = $timer->ReturnTimer();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Chargeur test de DataGrid</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="StyleSheet" type="text/css" href="datagrid.css" />
</head>
<body>
<?php
  $view =& $dgController1->getView();
  if ( !is_null( $view ) )
    $view->display();

  $view =& $dgController2->getView();
  if ( !is_null( $view ) )
    $view->display();

  /**
   * @todo    System::import semble super lente :\
   */
  echo sprintf(
    '<div style="border: 1px solid red; margin: 5px; padding: 4px; font-family: Verdana; font-size: 10px;">xml en %s, db en %s</div>',
    $xmlTime,
    $dbTime
  );
  echo sprintf(
    '<div style="border: 1px solid red; margin: 5px; padding: 4px; font-family: Verdana; font-size: 10px;">totalité en %s</div>',
    $genTimer->ReturnTimer()
  );
?>
</body>
</html>