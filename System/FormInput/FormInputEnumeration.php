<?php
  /**
   * @package     	FormInput
   * @class       	FormInputEnumeration
   * @author      	Jimmy CHARLEBOIS
   * @date        	12-01-2007
   * @brief       	Enumération pour FormInput
   */

  final class FormInputEnumeration {
    /**
     * @defgroup  FormInputType   Constantes pour les types d'éléments de formulaire
     */
    /*@{*/
    /** @brief  A utiliser pour un élément de type champ de saisie */
    const TYPE_TEXT       = 'text';
    /** @brief  A utiliser pour un élément de type case à cocher */
    const TYPE_CHECKBOX   = 'checkbox';
    /*@}*/

    /**
     * @defgroup  FormInputView   Constantes pour les différentes vues possibles pour les éléments de formulaire
     */
    /*@{*/
    /** @brief  Pour voir l'élément en mode visualisation */
    const READ_VIEW       = 'read';
    /** @brief  Pour voir l'élément en mode édition */
    const EDIT_VIEW       = 'edit';
    /** @brief  Pour voir l'élément en mode recherche */
    const SEARCH_VIEW     = 'search';
    /*@}*/

    /**
     * @defgroup  FormConfigType    Constantes pour les types d'éléments de configuration
     */
    /*@{*/
    const CONFIG_TYPE_HOLDER        = 'configuration';
    const CONFIG_TYPE_LENGTH        = 'length';
    const CONFIG_TYPE_SELECTED      = 'selected';
    /*@}*/

    private function __construct()
    {}
  }
?>