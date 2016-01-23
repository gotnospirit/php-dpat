<?php
  /**
   * @class       	CsvFile
   * @author      	Jimmy CHARLEBOIS
   * @date        	20-04-2007
   * @brief       	Permet de lire un fichier csv
   */
  System::import( 'System.Exceptions.UnsupportedOperationException' );
  System::import( 'System.IO.SysFile' );

  class CsvFile extends SysFile {
    public $delimiter;
    public $enclosure;

    public function __construct( $filepath ) {
      parent::__construct( $filepath );
      $this->delimiter = ';';
      $this->enclosure = '"';
    }

    /**
     * @todo  Faire l'implémentation spécifique à un fichier csv
     * $data devra forcément être un tableau 
     */
    public function write( $data ) {
      throw new UnsupportedOperationException( 'Cette opération n\'a pas encore été implémentée pour la classe CsvFile' );
    }

    public function readLine() {
      if ( is_null( $this->_resource ) )
        throw new IOException( 'File not opened' );
      return @fgetcsv( $this->_resource, null, $this->delimiter, $this->enclosure );
    }
  }
?>