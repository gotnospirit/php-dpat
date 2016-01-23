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
     * @todo  Faire l'impl�mentation sp�cifique � un fichier csv
     * $data devra forc�ment �tre un tableau 
     */
    public function write( $data ) {
      throw new UnsupportedOperationException( 'Cette op�ration n\'a pas encore �t� impl�ment�e pour la classe CsvFile' );
    }

    public function readLine() {
      if ( is_null( $this->_resource ) )
        throw new IOException( 'File not opened' );
      return @fgetcsv( $this->_resource, null, $this->delimiter, $this->enclosure );
    }
  }
?>