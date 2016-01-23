<?php
  /**
   * @package       Session
   * @interface     ISession
   * @author        Jimmy CHARLEBOIS
   * @date          10-12-2006
   */
  interface ISession {
    /**
     * @brief   M�thode appel�e lorsque l'on souhaite d�marrer la session
     * @return  boolean
     */
    public static function start();

    /**
     * @brief   M�thode appel�e lorsque l'on souhaite d�truire une variable de la session
     * @param   $key    string    le nom de la variable de session
     * @return  boolean
     */
    public static function delete( $key );

    /**
     * @brief   M�thode appel�e pour tester l'existance d'une variable de la session
     * @param   $key    string    le nom de la variable de session
     * @return  boolean
     */
    public static function exists( $key );

    /**
     * @brief   M�thode appel�e lorsque l'on souhaite r�cup�rer la valeur d'une variable de la session
     * @param   $key    string    le nom de la variable de session
     * @return  mixed
     */
    public static function &get( $key );

    /**
     * @brief   M�thode appel�e lorsque l'on souhaite r�cup�rer l'identifiant de la session en cours (ou pour une nouvelle session)
     * @return  string
     */
    public static function getUID();

    /**
     * @brief   M�thode appel�e lorsque l'on souhaite r�cup�rer la valeur d'une variable de la session
     * @param   $key      string    le nom de la variable de session
     * @param   $value    mixed     la valeur � stocker
     * @return  boolean
     */
    public static function set( $key, $value );
  }
?>