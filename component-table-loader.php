<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          28-02-2007
   * @brief         Exemple de chargement d'une table de donnée
   */
  require_once 'c.system.php';

  System::import( 'System.Table.Models.AbstractTableModel' );
  System::import( 'System.ADT.Scalar.String' );

  $model =& new AbstractTableModel(
    array(
      array( new String( 'hello' ) ),
      array( new String( 'world' ) )
    ),
    array( 'Colonne n°1' )
  );
?>