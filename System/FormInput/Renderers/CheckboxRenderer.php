<?php
  /**
   * @package       FormInput.Renderers
   * @class         CheckboxRenderer
   * @author        Jimmy CHARLEBOIS
   * @date          09-03-2007
   * @brief         
   */
  System::import( 'System.Interfaces.FormInput.IFormInputRenderer' );
  System::import( 'System.Xml.xmlElement' );

  class CheckboxRenderer implements IFormInputRenderer {
    private $_input;

    public function __construct( FormInput &$input ) {
      $this->_input =& $input;
    }

    public function renderRead() {
      $value = $this->_input->getValue();
      if ( is_null( $value ) )
        $value = $this->_input->getDefaultValue();
      return htmlspecialchars( $value );
    }

    public function renderEdit() {
      $value = $this->_input->getValue();

      $html =& new xmlElement( 'input' );
      $html->setAttribute( 'type', 'checkbox' );
      $html->setAttribute( 'name', $this->_input->getInputName() );

      if ( !FormInput::hasUserInput() )
        if ( is_null( $value ) )
          $value = $this->_input->getDefaultValue();

      if ( !is_null( $this->_input->getConfiguration() ) ) {
        if ( !FormInput::hasUserInput() ) {
          $configSelected = $this->_input->getConfiguration()->getConfig( FormInputEnumeration::CONFIG_TYPE_SELECTED );
          if ( !is_null( $configSelected ) && $configSelected->isSelected() )
            $html->setAttribute( 'checked', 'checked' );
        } else {
          if ( !is_null( $value ) )
            $html->setAttribute( 'checked', 'checked' );
        }
      }

      $html->setAttribute( 'value', htmlspecialchars( $value ) );

      return (string)$html;
    }

    public function renderSearch() {
      $name = $this->_input->getInputName().'_search';
      $value = ( $this->_input->getContext()->hasParam( $name ) )
        ? $this->_input->getContext()->getParam( $name ) : null;

      $html =& new xmlElement( 'input' );
      $html->setAttribute( 'type', 'text' );
      $html->setAttribute( 'name', $name );
      $html->setAttribute( 'value', $value );
      return (string)$html;
    }
  }
?>