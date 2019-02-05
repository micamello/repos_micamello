<?php
//namespace josemmo\Facturae\Controller;

//use josemmo\Facturae\FacturaeItem;

require_once 'C:/wamp64/www/facturae/src/Controller/FacturaeConstants.php';
require_once 'C:/wamp64/www/facturae/src/FacturaeItem.php';

/**
 * Implements all attributes and methods needed to make
 * @link{josemmo\Facturae\Facturae} instantiable.
 *
 * This includes all properties that define an electronic invoice, but without
 * additional functionalities such as signing or exporting.
 */
abstract class FacturaeProperties extends FacturaeConstants {

  /* ATTRIBUTES */
  protected $currency = "EUR";
  protected $language = "es";
  protected $version = null;
  protected $header = array(
    "serie" => null,
    "number" => null,
    "issueDate" => null,
    "dueDate" => null,
    "startDate" => null,
    "endDate" => null,
    "paymentMethod" => null,
    "paymentIBAN" => null,
    "description" => null,
    "receiverTransactionReference" => null,
    "fileReference" => null,
    "receiverContractReference" => null
  );
  protected $parties = array(
    "seller" => null,
    "buyer" => null
  );
  protected $items = array();
  protected $legalLiterals = array();
  protected $discounts = array();
  protected $charges = array();


  /**
   * Constructor for the class
   * @param string $schemaVersion If omitted, latest version available
   */
  public function __construct($schemaVersion=self::SCHEMA_3_2_1) {
    $this->setSchemaVersion($schemaVersion);
  }


  /**
   * Set schema version
   * @param  string   $schemaVersion FacturaE schema version to use
   * @return Facturae                Invoice instance
   */
  public function setSchemaVersion($schemaVersion) {
    $this->version = $schemaVersion;
    return $this;
  }


  /**
   * Get schema version
   * @return string FacturaE schema version to use
   */
  public function getSchemaVersion() {
    return $this->version;
  }


  /**
   * Set seller
   * @param  FacturaeParty $seller Seller information
   * @return Facturae              Invoice instance
   */
  public function setSeller($seller) {
    $this->parties['seller'] = $seller;
    return $this;
  }


  /**
   * Get seller
   * @return FacturaeParty|null Seller information
   */
  public function getSeller() {
    return $this->parties['seller'];
  }


  /**
   * Set buyer
   * @param  FacturaeParty $buyer Buyer information
   * @return Facturae             Invoice instance
   */
  public function setBuyer($buyer) {
    $this->parties['buyer'] = $buyer;
    return $this;
  }


  /**
   * Get buyer
   * @return FacturaeParty|null Buyer information
   */
  public function getBuyer() {
    return $this->parties['buyer'];
  }


  /**
   * Set invoice number
   * @param  string     $serie  Serie code of the invoice
   * @param  int|string $number Invoice number in given serie
   * @return Facturae           Invoice instance
   */
  public function setNumber($serie, $number) {
    $this->header['serie'] = $serie;
    $this->header['number'] = $number;
    return $this;
  }


  /**
   * Get invoice number
   * @return array Serie code and invoice number
   */
  public function getNumber() {
    return array(
      "serie" => $this->header['serie'],
      "number" => $this->header['number']
    );
  }


  /**
   * Set issue date
   * @param  int|string $date Issue date
   * @return Facturae         Invoice instance
   */
  public function setIssueDate($date) {
    $this->header['issueDate'] = is_string($date) ? strtotime($date) : $date;
    return $this;
  }


  /**
   * Get issue date
   * @return int|null Issue timestamp
   */
  public function getIssueDate() {
    return $this->header['issueDate'];
  }


  /**
   * Set due date
   * @param  int|string $date Due date
   * @return Facturae         Invoice instance
   */
  public function setDueDate($date) {
    $this->header['dueDate'] = is_string($date) ? strtotime($date) : $date;
    return $this;
  }


  /**
   * Get due date
   * @return int|null Due timestamp
   */
  public function getDueDate() {
    return $this->header['dueDate'];
  }


  /**
   * Set billing period
   * @param  int|string $date Start date
   * @param  int|string $date End date
   * @return Facturae         Invoice instance
   */
  public function setBillingPeriod($startDate, $endDate) {
    if (is_string($startDate)) $startDate = strtotime($startDate);
    if (is_string($endDate)) $endDate = strtotime($endDate);
    $this->header['startDate'] = $startDate;
    $this->header['endDate'] = $endDate;
    return $this;
  }


  /**
   * Get billing period
   * @return array Start and end dates for billing period
   */
  public function getBillingPeriod() {
    return array(
      "startDate" => $this->header['startDate'],
      "endDate" => $this->header['endDate']
    );
  }


  /**
   * Set dates
   * This is a shortcut for setting both issue and due date in a single line.
   * @param  int|string $issueDate Issue date
   * @param  int|string $dueDate   Due date
   * @return Facturae              Invoice instance
   */
  public function setDates($issueDate, $dueDate=null) {
    $this->setIssueDate($issueDate);
    $this->setDueDate($dueDate);
    return $this;
  }


  /**
   * Set payment method
   * @param  string      $method Payment method
   * @param  string|null $iban   Bank account in case of bank transfer
   * @return Facturae            Invoice instance
   */
  public function setPaymentMethod($method=self::PAYMENT_CASH, $iban=null) {
    $this->header['paymentMethod'] = $method;
    if (!is_null($iban)) $iban = str_replace(" ", "", $iban);
    $this->header['paymentIBAN'] = $iban;
    return $this;
  }


  /**
   * Get payment method
   * @return string|null Payment method
   */
  public function getPaymentMethod() {
    return $this->header['paymentMethod'];
  }


  /**
   * Get payment IBAN
   * @return string|null Payment bank account IBAN
   */
  public function getPaymentIBAN() {
    return $this->header['paymentIBAN'];
  }


  /**
   * Set description
   * @param  string   $desc Invoice description
   * @return Facturae       Invoice instance
   */
  public function setDescription($desc) {
    $this->header['description'] = $desc;
    return $this;
  }


  /**
   * Get description
   * @return string|null Invoice description
   */
  public function getDescription() {
    return $this->header['description'];
  }


  /**
   * Set references
   * @param  string   $file        File reference
   * @param  string   $transaction Transaction reference
   * @param  string   $contract    Contract reference
   * @return Facturae              Invoice instance
   */
  public function setReferences($file, $transaction=null, $contract=null) {
    $this->header['fileReference'] = $file;
    $this->header['receiverTransactionReference'] = $transaction;
    $this->header['receiverContractReference'] = $contract;
    return $this;
  }


  /**
   * Get file reference
   * @return string|null File reference
   */
  public function getFileReference() {
    return $this->header['fileReference'];
  }


  /**
   * Get transaction reference
   * @return string|null Transaction reference
   */
  public function getTransactionReference() {
    return $this->header['receiverTransactionReference'];
  }


  /**
   * Get contract reference
   * @return string|null Contract reference
   */
  public function getContractReference() {
    return $this->header['receiverContractReference'];
  }


  /**
   * Add legal literal
   * @param  string   $message Legal literal reference
   * @return Facturae          Invoice instance
   */
  public function addLegalLiteral($message) {
    $this->legalLiterals[] = $message;
    return $this;
  }


  /**
   * Get legal literals
   * @return string[] Legal literals
   */
  public function getLegalLiterals() {
    return $this->legalLiterals;
  }


  /**
   * Clear legal literals
   * @return Facturae Invoice instance
   */
  public function clearLegalLiterals() {
    $this->legalLiterals = array();
    return $this;
  }


  /**
   * Add general discount
   * @param  string   $reason       Discount reason
   * @param  float    $value        Discount percent or amount
   * @param  boolean  $isPercentage Whether value is percentage or not
   * @return Facturae               Invoice instance
   */
  public function addDiscount($reason, $value, $isPercentage=true) {
    $this->discounts[] = array(
      "reason" => $reason,
      "rate"   => $isPercentage ? $value : null,
      "amount" => $isPercentage ? null   : $value
    );
    return $this;
  }


  /**
   * Get general discounts
   * @return array Invoice general discounts
   */
  public function getDiscounts() {
    return $this->discounts;
  }


  /**
   * Clear general discounts
   * @return Facturae Invoice instance
   */
  public function clearDiscounts() {
    $this->discounts = array();
    return $this;
  }


  /**
   * Add general charge
   * @param  string   $reason       Charge reason
   * @param  float    $value        Charge percent or amount
   * @param  boolean  $isPercentage Whether value is percentage or not
   * @return Facturae               Invoice instance
   */
  public function addCharge($reason, $value, $isPercentage=true) {
    $this->charges[] = array(
      "reason" => $reason,
      "rate"   => $isPercentage ? $value : null,
      "amount" => $isPercentage ? null   : $value
    );
  }


  /**
   * Get general charges
   * @return array Invoice general charges
   */
  public function getCharges() {
    return $this->charges;
  }


  /**
   * Clear general charges
   * @return Facturae Invoice instance
   */
  public function clearCharges() {
    $this->charges = array();
    return $this;
  }


  /**
   * Add item
   *
   * Adds an item row to invoice. The fist parameter ($desc), can be an string
   * representing the item description or a 2 element array containing the item
   * description and an additional string of information.
   *
   * @param  FacturaeItem|string|array $desc      Item to add or description
   * @param  float                     $unitPrice Price per unit, taxes included
   * @param  float                     $quantity  Quantity
   * @param  int                       $taxType   Tax type
   * @param  float                     $taxRate   Tax rate
   * @return Facturae                             Invoice instance
   */
  public function addItem($desc, $unitPrice=null, $quantity=1, $taxType=null,
                          $taxRate=null) {
    if ($desc instanceOf FacturaeItem) {
      $item = $desc;
    } else {
      $item = new FacturaeItem([
        "name" => is_array($desc) ? $desc[0] : $desc,
        "description" => is_array($desc) ? $desc[1] : null,
        "quantity" => $quantity,
        "unitPrice" => $unitPrice,
        "taxes" => array($taxType => $taxRate)
      ]);
    }
    $this->items[] = $item;
    return $this;
  }


  /**
   * Get invoice items
   * @return FacturaeItem[] Invoice items
   */
  public function getItems() {
    return $this->items;
  }


  /**
   * Clear invoice items
   * @return Facturae Invoice instance
   */
  public function clearItems() {
    $this->items = array();
    return $this;
  }


  /**
   * Get totals
   * @return array Invoice totals
   */
  public function getTotals() {
    // Define starting values
    $totals = array(
      "taxesOutputs" => array(),
      "taxesWithheld" => array(),
      "generalDiscounts" => array(),
      "generalCharges" => array(),
      "invoiceAmount" => 0,
      "grossAmount" => 0,
      "totalGeneralDiscounts" => 0,
      "totalGeneralCharges" => 0,
      "totalTaxesOutputs" => 0,
      "totalTaxesWithheld" => 0
    );

    // Run through every item
    foreach ($this->items as $itemObj) {
      $item = $itemObj->getData($this);
      $totals['grossAmount'] += $item['grossAmount'];
      $totals['totalTaxesOutputs'] += $item['totalTaxesOutputs'];
      $totals['totalTaxesWithheld'] += $item['totalTaxesWithheld'];

      // Get taxes
      foreach (["taxesOutputs", "taxesWithheld"] as $taxGroup) {
        foreach ($item[$taxGroup] as $type=>$tax) {
          if (!isset($totals[$taxGroup][$type])) {
            $totals[$taxGroup][$type] = array();
          }
          if (!isset($totals[$taxGroup][$type][$tax['rate']])) {
            $totals[$taxGroup][$type][$tax['rate']] = array(
              "base" => 0,
              "amount" => 0
            );
          }
          $totals[$taxGroup][$type][$tax['rate']]['base'] += $tax['base'];
          $totals[$taxGroup][$type][$tax['rate']]['amount'] += $tax['amount'];
        }
      }
    }

    // Normalize gross amount (needed for next step)
    $totals['grossAmount'] = $this->pad($totals['grossAmount']);

    // Get general discounts and charges
    foreach (['discounts', 'charges'] as $groupTag) {
      foreach ($this->{$groupTag} as $item) {
        if (is_null($item['rate'])) {
          $rate = null;
          $amount = $item['amount'];
        } else {
          $rate = $this->pad($item['rate'], 'Discount/Rate');
          $amount = $totals['grossAmount'] * ($rate / 100);
        }
        $amount = $this->pad($amount, 'Discount/Amount');
        $totals['general' . ucfirst($groupTag)][] = array(
          "reason" => $item['reason'],
          "rate" => $rate,
          "amount" => $amount
        );
        $totals['totalGeneral' . ucfirst($groupTag)] += $amount;
      }
    }

    // Normalize rest of values
    $totals['totalTaxesOutputs'] = $this->pad($totals['totalTaxesOutputs']);
    $totals['totalTaxesWithheld'] = $this->pad($totals['totalTaxesWithheld']);
    $totals['totalGeneralDiscounts'] = $this->pad($totals['totalGeneralDiscounts']);
    $totals['totalGeneralCharges'] = $this->pad($totals['totalGeneralCharges']);

    // Fill missing values
    $totals['grossAmountBeforeTaxes'] = $this->pad($totals['grossAmount'] -
      $totals['totalGeneralDiscounts'] + $totals['totalGeneralCharges']);
    $totals['invoiceAmount'] = $this->pad($totals['grossAmountBeforeTaxes'] +
      $totals['totalTaxesOutputs'] - $totals['totalTaxesWithheld']);

    return $totals;
  }

}
