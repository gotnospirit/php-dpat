<?php
  /**
   * @package       Form
   * @interface     IFormCheckerModifier
   * @author        Jimmy CHARLEBOIS
   * @date          13-06-2006
   * @brief         Interface pour les modificateurs de valeur de champ
   * @note          Les modificateurs sont appelés via la méthode process du formulaire
   */
  interface IFormCheckerModifier {
    /**
    * @brief    Méthode statique appelée pour modifier la valeur du champ cible
    * @param    $oField FormChecker_Field la représentation du champ de formulaire
    * @param    $params paramètres permettant à l'assistant de modifier la valeur du champ
    * @return   void
    */
    public function process( FormChecker_Field &$oField, $params = null );
  }
?>