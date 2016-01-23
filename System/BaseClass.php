<?php
  /**
   * @package       Base
   * @class         BaseClass
   * @author        Jimmy CHARLEBOIS
   * @date          05-12-2006
   * @brief         Classe de base pour les composants de bas niveau
   */
  System::import( 'System.Interfaces.IBaseClass' );

  abstract class BaseClass implements IBaseClass {
    public function __construct()
    {}

    public function getClassname() { return get_class( $this ); }
    public function isInstanceOf( $obj ) { return is_a( $obj, $this->getClassname() ); }
  }
?>