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
     * @brief   D�finit l'url vers laquelle le message Http doit �tre envoy�
     * @param   $url    string    Adresse URL
     * @return  void
     */
    public function setUrl( $url );
    /**
     * @brief   Retourne l'url associ�e au message Http
     * @return  string
     */
    public function getUrl();

    /**
     * @brief   D�finit la m�thode � utiliser pour l'envoi du message
     * @param   $method   const   M�thode Http � utiliser \ref HttpMessageMethod
     * @return  void
     * @throw   Exception
     */
    public function setMethod( $method );
    /**
     * @brief   Retourne la m�thode d'envoi d�finit pour le message
     * @return  \ref HttpMessageMethod
     */
    public function getMethod();

    /**
     * @brief   Ajoute un ent�te Http
     * @param   $key    string    Le nom de l'ent�te
     * @param   $value  string    La valeur qu'il doit prendre
     * @return  void
     */
    public function addHeader( $key, $value );
    /**
     * @brief   Retourne une collection des ent�tes d�clar�s
     * @return  array
     */
    public function getHeaders();

    /**
     * @brief   D�finit les param�tres de l'url
     * @param   $value    array   Collection des param�tres
     * @return  void
     * @throw   Exception
     */
    public function setQueryString( $value );

    /**
     * @brief   Retour les param�tres de l'url
     * @return  array
     */
    public function getQueryString();

    /**
     * @brief   D�finit la version du protocole a utiliser
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
     * @brief   D�finit le corps du message
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
     * @brief   D�finit le code de la r�ponse Http
     * @param   $code   integer   Num�ro du code Http
     * @return  void
     * @throw   Exception
     */
    public function setResponseCode( $code );

    /**
     * @brief   Retourne le code de la r�ponse Http
     * @return  integer
     */
    public function getResponseCode();

    /**
     * @brief   D�finit le statut de la r�ponse Http
     * @param   $statut   string   Le texte d'explication suivant le code de la r�ponse
     * @return  void
     */
    public function setResponseStatut( $statut );

    /**
     * @brief   Retourne le statut de la r�ponse Http
     * @return  string
     */
    public function getResponseStatut();
  }
?>