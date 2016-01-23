<?php
  /**
   * @package       DataGrid
   * @class         DataGridSource
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         Fabrique Abstraite pour les sources de données des DataGrid
   */
  System::import( 'System.DataSource.DataSource' );
  System::import( 'System.DataSource.DataSourceDriver' );

  abstract class DataGridSource extends DataSource {
    public function __construct( IDataSourceDriver &$driver ) {
      parent::__construct( $driver );
    }

    /**
     * @brief   Instancie la classe concrête correspondante à la signature de driver fournie
     * @param   $driverSignature   string   signature du driver
     * @return  DataGridSource
     * @throw   Exception
     */
    final public function &createNew( $driverSignature ) {
      $rv = null;
      $dgDriver =& DataSourceDriver::createNew( $driverSignature );
      if ( 'xml' == $dgDriver->getScheme() ) {
        System::import( 'System.DataGrid.DataSources.XmlDataGridSource' );
        $rv =& new XmlDataGridSource( $dgDriver );
      /**
       * @todo    Supprimer ce if = 'mysql' car on devrait pas avoir a connaitre le type de dbms
       *  modification du driver ?
       *  appel à une méthode statique de dbmsdatasource/dbmsdatagridsource ?
       */
      } elseif ( 'mysql' == $dgDriver->getScheme() ) {
        System::import( 'System.DataGrid.DataSources.DbmsDataGridSource' );
        $rv =& new DbmsDataGridSource( $dgDriver );
      } else {
        throw new Exception( 'Unsupported datasource scheme' );
      }
      return $rv;
    }

    /**
     * @brief   Retourne un datagrid d'après le driver fournit
     * @return  DataGrid
     * @throw   Exception
     */
    abstract public function &getDataGrid( IDataSourceExpression &$expression );
  }
?>