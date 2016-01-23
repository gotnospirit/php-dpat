<?php
  /**
   * @package     	FormInput
   * @class       	FormInputEnumeration
   * @author      	Jimmy CHARLEBOIS
   * @date        	12-01-2007
   * @brief       	Enum�ration pour FormInput
   */

  final class FormInputEnumeration {
    /**
     * @defgroup  FormInputType   Constantes pour les types d'�l�ments de formulaire
     */
    /*@{*/
    /** @brief  A utiliser pour un �l�ment de type champ de saisie */
    const TYPE_TEXT       = 'text';
    /** @brief  A utiliser pour un �l�ment de type case � cocher */
    const TYPE_CHECKBOX   = 'checkbox';
    /*@}*/

    /**
     * @defgroup  FormInputView   Constantes pour les diff�rentes vues possibles pour les �l�ments de formulaire
     */
    /*@{*/
    /** @brief  Pour voir l'�l�ment en mode visualisation */
    const READ_VIEW       = 'read';
    /** @brief  Pour voir l'�l�ment en mode �dition */
    const EDIT_VIEW       = 'edit';
    /** @brief  Pour voir l'�l�ment en mode recherche */
    const SEARCH_VIEW     = 'search';
    /*@}*/

    /**
     * @defgroup  FormConfigType    Constantes pour les types d'�l�ments de configuration
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