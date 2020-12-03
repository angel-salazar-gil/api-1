<?php

use Dotenv\Result\Result;

$xml=new DOMDocument("1.0");
$xml->formatOutput=true;
$permisos=$xml->createElement("permiso");
$xml->appendChild($permisos);

while($row->mysql_fetch_array($result)){
$permisos=$xml->createElement("permiso");
$permisos->appendChild($permisos);
}

echo "<xmp".$xml->saveXML()."</xmp>";

$xml->save("reports.xml");
