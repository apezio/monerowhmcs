<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

use WHMCS\Database\Capsule as Capsule;

// skip checking for fraud order
function moneroEnable ( $vars ) {
	$option1 = Capsule::select("SELECT `value` FROM tbladdonmodules WHERE module = 'moneroEnable' AND setting = 'option1' LIMIT 1")[0]->value;
	$option2 = Capsule::select("SELECT `value` FROM tbladdonmodules WHERE module = 'moneroEnable' AND setting = 'option2' LIMIT 1")[0]->value;
	if($option1 == 'on' && $option2 > '' && $vars['orderid'] > '') {
		$paymentMethod = Capsule::select("SELECT paymentmethod FROM tblorders WHERE id = ".$vars['orderid'])[0]->paymentmethod;
		if($paymentMethod > '') {
			if($paymentMethod == $option2) return true;
		}
	}
}

add_hook("RunFraudCheck", 1, "moneroEnable");

?>
