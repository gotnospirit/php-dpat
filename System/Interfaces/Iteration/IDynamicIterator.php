<?php
  /**
   * @package     	Iteration
   * @interface     IDynamicIterator
   * @author      	Jimmy CHARLEBOIS
   * @date        	07-03-2007
   * @brief       	Interface pour itérateur pouvant aussi avancer que reculer leur curseur
   */
  System::import( 'System.Interfaces.Iteration.IIterator' );

  interface IDynamicIterator extends IIterator {
    /**
     * @brief   Repositionne le curseur au début
     * @return  void
     */
    public function rewind();

    /**
     * @brief   Retourne l'élément situé à la position du pointeur interne de l'itérateur
     * @return  mixed|null
     */
    public function &current();

    /**
     * @brief   Retourne la prochaine position du pointeur
     * @return  integer|null
     */
    public function nextIndex();

    /**
     * @brief   Indique si la collection a déjà énuméré un élément
     * @return  boolean
     */
    public function hasPrevious();

    /**
     * @brief   Retourne la précédente position du pointeur
     * @return  integer|null
     */
    public function previousIndex();

    /**
     * @brief   Retourne le précédent élément énumérable et décrémente le pointeur interne de l'itérateur
     * @return  mixed|null
     */
    public function &previous();
  }
?>