<?php
  /**
   * @package     	FormInput
   * @interface     IFormInput
   * @author      	Jimmy CHARLEBOIS
   * @date        	12-01-2007
   * @brief       	Interface pour �l�ment de formulaire
   */
  System::import( 'System.Interfaces.IStorable' );

  interface IFormInput extends IStorable {
    /**
     * @brief   Retourne le nom de l'�l�ment
     * @return  string
     */
    public function getInputName();

    /**
     * @brief   D�finit la valeur de l'�l�ment
     * @param   $value    mixed   la valeur de l'�l�ment (pas forc�ment scalaire)
     * @return  void
     */
    public function setValue( $value );

    /**
     * @brief   Retourne la valeur de l'�l�ment
     * @return  mixed
     */
    public function getValue();

    /**
     * @brief   Retourne le type de l'�l�ment de formulaire
     * @return  const   \ref FormInputType
     */
    public function getType();

    /**
     * @brief   D�finit la valeur par d�faut de l'�l�ment
     * @param   $value    mixed   la valeur de l'�l�ment (pas forc�ment scalaire)
     * @return  void
     */
    public function setDefaultValue( $value );

    /**
     * @brief   Retourne la valeur par d�faut de l'�l�ment
     * @return  mixed
     */
    public function getDefaultValue();

    /**
     * @brief   Dessine l'�l�ment
     * @param   $view_type    const   \ref FormInputView
     * @return  mixed
     */
    public function render( $view_type );
  }
?>