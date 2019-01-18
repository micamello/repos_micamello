<?php
require_once('src/Facturae.php');
require_once('src/FacturaeParty.php');

$fac = new Facturae();
$fac->setNumber('FAC201804', '123');
$fac->setIssueDate('2018-04-01');

$fac->setSeller(new FacturaeParty([
  "taxNumber" => "A00000000",
  "name"      => "Perico de los Palotes S.A.",
  "address"   => "C/ Falsa, 123",
  "postCode"  => "12345",
  "town"      => "Madrid",
  "province"  => "Madrid"
]));
$fac->setBuyer(new FacturaeParty([
  "isLegalEntity" => false,
  "taxNumber"     => "00000000A",
  "name"          => "Antonio",
  "firstSurname"  => "García",
  "lastSurname"   => "Pérez",
  "address"       => "Avda. Mayor, 7",
  "postCode"      => "54321",
  "town"          => "Madrid",
  "province"      => "Madrid"
]));

$fac->addItem("Lámpara de pie", 20.14, 3, Facturae::TAX_IVA, 21);

$fac->sign("widman_ivan_hidrovo_benalcazar.p12", null, "Amor2018");
$fac->export("mi-factura.xml");
?>