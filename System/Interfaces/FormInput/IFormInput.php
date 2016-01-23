<?php
  /**
   * @package     	FormInput
   * @interface     IFormInput
   * @author      	Jimmy CHARLEBOIS
   * @date        	12-01-2007
   * @brief       	Interface pour élément de formulaire
   */
  System::import( 'System.Interfaces.IStorable' );

  interface IFormInput extends IStorable {
    /**
     * @brief   Retourne le nom de l'élément
     * @return  string
     */
    public function getInputName();

    /**
     * @brief   Définit la valeur de l'élément
     * @param   $value    mixed   la valeur de l'élément (pas forcément scalaire)
     * @return  void
     */
    public function setValue( $value );

    /**
     * @brief   Retourne la valeur de l'élément
     * @return  mixed
     */
    public function getValue();

    /**
     * @brief   Retourne le type de l'élément de formulaire
     * @return  const   \ref FormInputType
     */
    public function getType();

    /**
     * @brief   Définit la valeur par défaut de l'élément
     * @param   $value    mixed   la valeur de l'élément (pas forcément scalaire)
     * @return  void
     */
    public function setDefaultValue( $value );

    /**
     * @brief   Retourne la valeur par défaut de l'élément
     * @return  mixed
     */
    public function getDefaultValue();

    /**
     * @brief   Dessine l'élément
     * @param   $view_type    const   \ref FormInputView
     * @return  mixed
     */
    public function render( $view_type );
  }
?>