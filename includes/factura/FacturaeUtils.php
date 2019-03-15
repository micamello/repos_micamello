<?php
require_once RUTA_INCLUDES.'factura/FacturaeProperties.php';

/**
 * Implements utilitary methods for an instantiable
 * @link{josemmo\Facturae\Facturae}.
 */
abstract class FacturaeUtils extends FacturaeProperties {

  protected $extensions = array();


  /**
   * Pad
   *
   * @param  float       $val   Input value
   * @param  string|null $field Field
   * @return string             Padded value
   */
  public function pad($val, $field=null) {
    // Get decimals
    $vKey = isset(self::$DECIMALS[$this->version]) ? $this->version : null;
    $decimals = self::$DECIMALS[$vKey];
    if (!isset($decimals[$field])) $field = null;
    $decimals = $decimals[$field];

    // Pad value
    $res = number_format(round($val, $decimals['max']), $decimals['max'], ".", "");
    for ($i=0; $i<$decimals['max']-$decimals['min']; $i++) {
      if (substr($res, -1) !== "0") break;
      $res = substr($res, 0, -1);
    }
    return $res;
  }


  /**
   * Get XML Namespaces
   * @return string[] XML Namespaces
   */
  protected function getNamespaces() {
    $xmlns = array();
    $xmlns[] = 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#"';
    //$xmlns[] = 'xmlns:fe="' . self::$SCHEMA_NS[$this->version] . '"';    
    $xmlns[] = 'xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#"';    
    return $xmlns;
  }


  /**
   * Get extension
   * @param  string    $name Extension name
   * @return Extension       Extension instance
   */
  public function getExtension($name) {
    if (!isset($this->extensions[$name])) {
      $namespace = __NAMESPACE__ . "\\Extensions\\{$name}Extension";
      $this->extensions[$name] = new $namespace($this);
    }
    return $this->extensions[$name];
  }

}
