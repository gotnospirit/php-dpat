<?php
  /**
   * @package     	Iteration
   * @interface     IDynamicIterator
   * @author      	Jimmy CHARLEBOIS
   * @date        	07-03-2007
   * @brief       	Interface pour it�rateur pouvant aussi avancer que reculer leur curseur
   */
  System::import( 'System.Interfaces.Iteration.IIterator' );

  interface IDynamicIterator extends IIterator {
    /**
     * @brief   Repositionne le curseur au d�but
     * @return  void
     */
    public function rewind();

    /**
     * @brief   Retourne l'�l�ment situ� � la position du pointeur interne de l'it�rateur
     * @return  mixed|null
     */
    public function &current();

    /**
     * @brief   Retourne la prochaine position du pointeur
     * @return  integer|null
     */
    public function nextIndex();

    /**
     * @brief   Indique si la collection a d�j� �num�r� un �l�ment
     * @return  boolean
     */
    public function hasPrevious();

    /**
     * @brief   Retourne la pr�c�dente position du pointeur
     * @return  integer|null
     */
    public function previousIndex();

    /**
     * @brief   Retourne le pr�c�dent �l�ment �num�rable et d�cr�mente le pointeur interne de l'it�rateur
     * @return  mixed|null
     */
    public function &previous();
  }
?>