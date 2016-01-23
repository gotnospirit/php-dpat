<?php
  /**
   * @package       DataSource
   * @interface     IDataSource
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief				
   */
  System::import( 'System.Interfaces.IResource' );

  interface IDataSource extends IResource {
    /**
     * @brief   Retourne le driver associé
     * @return  IDataSourceDriver
     */
    public function getDriver();
  }
?>