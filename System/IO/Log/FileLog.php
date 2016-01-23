<?php
  /**
   * @package     	Log
   * @class       	FileLog
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-01-2007
   * @brief       	Fichier de journalisation
   * @code
   *   $log =& new FileLog( 'test.log' );
   *   $log->write( 'Un message à logguer !' );
   *   $log->dispose();
   * @endcode
   */
  System::import( 'System.Interfaces.Log.ILog' );
  System::import( 'System.IO.SysFile' );

  class FileLog implements ILog, IResource {
    private $_resource;

    public function __construct( $filename ) {
      $this->_resource = new SysFile( $filename );
      $this->_resource->open( SysFile::APPEND_ACCESS );
    }

    public function write( $data ) {
      $data = sprintf(
        '[%s] %s%s',
        date( 'Y-m-d H:i:s' ),
        $data,
        System::crlf
      );
      return $this->_resource->write( $data );
    }

    public function dispose() {
      $this->_resource->close();
    }

    public function reset() {
      $this->dispose();
      $this->_resource->open( SysFile::WRITE_ACCESS );
    }
  }
?>