<?php
  /**
   * @package       Iteration
   * @interface     IIterable
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Interface permettant d'obtenir de la part d'une collection (ou d'un objet la poss�dant) un objet impl�mentant le pattern Iterateur (IIterator)
   */
  interface IIterable {
    /**
     * @brief   Retourne un objet impl�mentant IIterator
     * @return  IIterator
     */
    public function getIterator();

    /**
     * @brief   Retourne la taille de l'objet IIterable
     * @return  integer
     */
    public function size();

    /**
     * @brief   Retourne un nouveau tableau de l'objet IIterable
     * @return  array
     */
    public function toArray();
  }
?>