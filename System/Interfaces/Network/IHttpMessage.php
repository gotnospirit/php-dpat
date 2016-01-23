<?php
  /**
   * @package       Network.Http
   * @interface     IHttpMessage
   * @author        Jimmy CHARLEBOIS
   * @date          14-02-2007
   * @brief         Interface pour message HTTP
   */
  interface IHttpMessage {
    /**
     * @brief   Définit l'url vers laquelle le message Http doit être envoyé
     * @param   $url    string    Adresse URL
     * @return  void
     */
    public function setUrl( $url );
    /**
     * @brief   Retourne l'url associée au message Http
     * @return  string
     */
    public function getUrl();

    /**
     * @brief   Définit la méthode à utiliser pour l'envoi du message
     * @param   $method   const   Méthode Http à utiliser \ref HttpMessageMethod
     * @return  void
     * @throw   Exception
     */
    public function setMethod( $method );
    /**
     * @brief   Retourne la méthode d'envoi définit pour le message
     * @return  \ref HttpMessageMethod
     */
    public function getMethod();

    /**
     * @brief   Ajoute un entête Http
     * @param   $key    string    Le nom de l'entête
     * @param   $value  string    La valeur qu'il doit prendre
     * @return  void
     */
    public function addHeader( $key, $value );
    /**
     * @brief   Retourne une collection des entêtes déclarés
     * @return  array
     */
    public function getHeaders();

    /**
     * @brief   Définit les paramètres de l'url
     * @param   $value    array   Collection des paramètres
     * @return  void
     * @throw   Exception
     */
    public function setQueryString( $value );

    /**
     * @brief   Retour les paramètres de l'url
     * @return  array
     */
    public function getQueryString();

    /**
     * @brief   Définit la version du protocole a utiliser
     * @param   $version    const   \ref HttpMessageVersion
     * @return  void
     * @throw   Exception
     */
    public function setVersion( $version );

    /**
     * @brief   Retourne la version du protocole
     * @return  \ref HttpMessageVersion
     */
    public function getVersion();

    public function setRaw( $raw );
    public function getRaw();

    /**
     * @brief   Définit le corps du message
     * @param   $body   string   contenu du message
     * @return  void
     */
    public function setBody( $body );
    /**
     * @brief   Retourne le corps du message
     * @return  string
     */
    public function getBody();

    /**
     * @brief   Définit le code de la réponse Http
     * @param   $code   integer   Numéro du code Http
     * @return  void
     * @throw   Exception
     */
    public function setResponseCode( $code );

    /**
     * @brief   Retourne le code de la réponse Http
     * @return  integer
     */
    public function getResponseCode();

    /**
     * @brief   Définit le statut de la réponse Http
     * @param   $statut   string   Le texte d'explication suivant le code de la réponse
     * @return  void
     */
    public function setResponseStatut( $statut );

    /**
     * @brief   Retourne le statut de la réponse Http
     * @return  string
     */
    public function getResponseStatut();
  }
?>