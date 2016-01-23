<?php
  /**
   * @package     	Network.ClientServer.FTP
   * @class       	FTPMessage
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-04-2007
   * @brief       	Encapsulation d'un message FTP
   */

  class FTPMessage {
    private $_raw;
    private $_code;
    private $_command;
    private $_params;

    private function __construct( $raw, $code, $command, $params ) {
      $this->_raw = $raw;
      $this->_code = $code;
      $this->_command = $command;
      $this->_params = $params;
    }

    /**
     * @brief   Accesseurs en lecture
     */
    public function __get( $varName ) {
      if ( 'code' == $varName )
        return $this->_code;
      elseif ( 'command' == $varName )
        return $this->_command;
      elseif ( 'params' == $varName )
        return $this->_params;
      elseif ( 'raw' == $varName )
        return $this->_raw;
    }

    public function __toString() {
      return '[FTPMessage]'.System::crlf
        . 'Code : '.$this->_code.System::crlf
        . 'Command : '.$this->_command.System::crlf
        . 'Params : '.$this->params.System::crlf
        . 'Raw : '.$this->_raw.System::crlf
        ;
    }

    /**
     * @brief   Parse une réponse ftp
     * @param   $rawResponse    string    la chaîne d'instruction ftp
     * @return  FTPMessage
     */
    public static function &parse( $rawResponse ) {
      $rv = null;

      $matches = array();
      preg_match( '~([0-9]{3} )?(.*)$~', trim( $rawResponse ), $matches );
      if ( 0 != count( $matches ) ) {
        $responseCode = ( isset( $matches[ 1 ] ) && mb_strlen( $matches[ 1 ] ) > 0 )
          ? trim( $matches[ 1 ] ): null;
        $commandName = null;
        $commandParams = null;

        if ( strlen( $matches[ 2 ] ) > 0 ) {
          if ( is_null( $responseCode ) ) { // Pas de code donc surement une commande
            preg_match( '~([A-Z]+)( .*)?$~', trim( $matches[ 2 ] ), $matches );
            if ( count( $matches ) > 0 ) {
              $commandName = trim( $matches[ 1 ] );
              $commandParams = ( isset( $matches[ 2 ] ) )
                ? trim( $matches[ 2 ] ) : null;
            }
          } else {
            $commandParams = trim( $matches[ 2 ] );
          }
        }

        $rv =& new FTPMessage( $rawResponse, $responseCode, $commandName, $commandParams );
      }
      return $rv;
    }
  }
?>