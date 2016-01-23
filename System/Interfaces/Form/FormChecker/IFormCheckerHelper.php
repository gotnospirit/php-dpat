<?php
  /**
   * @package       Form
   * @interface     IFormCheckerHelper
   * @author        Jimmy CHARLEBOIS
   * @date          13-06-2006
   * @brief         Interface pour les assistants de formulaire
   */
  interface IFormCheckerHelper {
    /**
     * @brief   M�thode statique appel�e pour v�rifier un champ de formulaire
     * @param   $oField   FormChecker_Field   la repr�sentation du champ de formulaire
     * @param   $params   array               param�tre permettant � l'assistant de v�rifier le champ
     * @return  boolean
     * @warning En cas d'�chec lors de la v�rification, en plus de retourner false, l'assistant doit ajouter une erreur sur le champ \ref FormChecker_Field::raiseError
     */
    public static function check( FormChecker_Field &$oField, $params );
  }
?>