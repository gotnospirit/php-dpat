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
     * @brief   Méthode statique appelée pour vérifier un champ de formulaire
     * @param   $oField   FormChecker_Field   la représentation du champ de formulaire
     * @param   $params   array               paramètre permettant à l'assistant de vérifier le champ
     * @return  boolean
     * @warning En cas d'échec lors de la vérification, en plus de retourner false, l'assistant doit ajouter une erreur sur le champ \ref FormChecker_Field::raiseError
     */
    public static function check( FormChecker_Field &$oField, $params );
  }
?>