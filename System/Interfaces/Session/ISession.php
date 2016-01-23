<?php
  /**
   * @package       Session
   * @interface     ISession
   * @author        Jimmy CHARLEBOIS
   * @date          10-12-2006
   */
  interface ISession {
    /**
     * @brief   Méthode appelée lorsque l'on souhaite démarrer la session
     * @return  boolean
     */
    public static function start();

    /**
     * @brief   Méthode appelée lorsque l'on souhaite détruire une variable de la session
     * @param   $key    string    le nom de la variable de session
     * @return  boolean
     */
    public static function delete( $key );

    /**
     * @brief   Méthode appelée pour tester l'existance d'une variable de la session
     * @param   $key    string    le nom de la variable de session
     * @return  boolean
     */
    public static function exists( $key );

    /**
     * @brief   Méthode appelée lorsque l'on souhaite récupérer la valeur d'une variable de la session
     * @param   $key    string    le nom de la variable de session
     * @return  mixed
     */
    public static function &get( $key );

    /**
     * @brief   Méthode appelée lorsque l'on souhaite récupérer l'identifiant de la session en cours (ou pour une nouvelle session)
     * @return  string
     */
    public static function getUID();

    /**
     * @brief   Méthode appelée lorsque l'on souhaite récupérer la valeur d'une variable de la session
     * @param   $key      string    le nom de la variable de session
     * @param   $value    mixed     la valeur à stocker
     * @return  boolean
     */
    public static function set( $key, $value );
  }
?>