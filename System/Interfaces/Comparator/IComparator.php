<?php
  /**
   * @package       Comparator
   * @interface     IComparator
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief         Interface pour comparateur d'objet IComparable
   */
  interface IComparator {
    /**
     * @brief   Compare deux objets du même type afin de pourvoir les ordonnancer
     * @param   $a    IComparable
     * @param   $b    IComparable
     * @return  - -1  si $a est inférieur à $b
     *          - 1   si $a est supérieur à $b
     *          - 0   si $a est égale à $b
     * @throw   IllegalArgumentException  
     */
    public function compare( IComparable $a, IComparable $b );
  }
?>