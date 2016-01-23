<?php
  /**
   * @package       Iteration
   * @interface     IIterable
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Interface permettant d'obtenir de la part d'une collection (ou d'un objet la possédant) un objet implémentant le pattern Iterateur (IIterator)
   */
  interface IIterable {
    /**
     * @brief   Retourne un objet implémentant IIterator
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