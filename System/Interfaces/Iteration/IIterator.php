<?php
  /**
   * @package       Iteration
   * @interface     IIterator
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Interface pour impl�mentation du pattern Iterateur
   */
  System::import( 'System.Interfaces.IObject' );

  interface IIterator extends IObject {
    /**
     * @brief   Indique si la collection peut encore �tre parcourue
     * @return  boolean
     */
    public function hasNext();

    /**
     * @brief   Retourne la cl� courante
     * @return  mixed
     */
    public function key();

    /**
     * @brief   Retourne le prochain �l�ment �num�rable et incr�mente le pointeur interne de l'it�rateur
     * @return  mixed|null
     */
    public function &next();

    /**
     * @brief   Supprime le dernier �l�ment retourn� par la m�thode next()
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function remove();

    /**
     * @brief   Permet de repositionner le pointeur interne de l'it�rateur
     * @return  boolean
     * @throw   UnsupportedOperationException, IllegalArgumentException
     */
    public function seek( $position );
  }
?>