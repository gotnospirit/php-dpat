<?php
  /**
   * @package       Comparator
   * @interface     IComparable
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Interface pour les objets pouvant �tre compar�
   */
  interface IComparable {
    /**
     * @brief   Compare deux objets du m�me type afin de pourvoir les ordonnancer
     * @param   $o    IComparable
     * @throw   IllegalArgumentException
     */
    public function compareTo( IComparable $o );
  }
?>