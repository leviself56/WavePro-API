<?php
require_once("class.wavepro.php");

$EdgeOS = new WavePro($ip="10.15.100.170", $user="ubnt", $pass="pass");
echo "<pre>";
print_r($EdgeOS->GetInterfaces());
print_r($EdgeOS->GetDevice());
print_r($EdgeOS->GetWirelessStatistics());
echo "</pre>";

?>