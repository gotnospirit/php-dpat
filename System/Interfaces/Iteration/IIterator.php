<?php
  /**
   * @package       Iteration
   * @interface     IIterator
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Interface pour implémentation du pattern Iterateur
   */
  System::import( 'System.Interfaces.IObject' );

  interface IIterator extends IObject {
    /**
     * @brief   Indique si la collection peut encore être parcourue
     * @return  boolean
     */
    public function hasNext();

    /**
     * @brief   Retourne la clé courante
     * @return  mixed
     */
    public function key();

    /**
     * @brief   Retourne le prochain élément énumérable et incrémente le pointeur interne de l'itérateur
     * @return  mixed|null
     */
    public function &next();

    /**
     * @brief   Supprime le dernier élément retourné par la méthode next()
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function remove();

    /**
     * @brief   Permet de repositionner le pointeur interne de l'itérateur
     * @return  boolean
     * @throw   UnsupportedOperationException, IllegalArgumentException
     */
    public function seek( $position );
  }
?>