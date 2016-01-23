<?php
  /**
   * @package       Form
   * @interface     IFormCheckerModifier
   * @author        Jimmy CHARLEBOIS
   * @date          13-06-2006
   * @brief         Interface pour les modificateurs de valeur de champ
   * @note          Les modificateurs sont appel�s via la m�thode process du formulaire
   */
  interface IFormCheckerModifier {
    /**
    * @brief    M�thode statique appel�e pour modifier la valeur du champ cible
    * @param    $oField FormChecker_Field la repr�sentation du champ de formulaire
    * @param    $params param�tres permettant � l'assistant de modifier la valeur du champ
    * @return   void
    */
    public function process( FormChecker_Field &$oField, $params = null );
  }
?>