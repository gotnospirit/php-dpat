<?php
  /**
   * @package     	DataGrid
   * @interface     IDataGridSource
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-11-2006
   * @brief       	
   */
  System::import( 'System.Interfaces.DataSource.IDataSource' );

  interface IDataGridSource extends IDataSource {
    /**
     * @brief   Retourne un datagrid d'après l'expression fournie
     * @param   $expression   IDataSourceExpression   l'expression permettant de pointer les données visées
     * @return  DataGrid
     * @throw   Exception
     */
    public function &getDataGrid( IDataSourceExpression &$expression );
  }
?>