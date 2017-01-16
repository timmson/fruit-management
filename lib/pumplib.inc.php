<?
set_time_limit(70);
function addInCreditInsurance($dom, $absid, $type, $rate, $sum) {
	$ccd = $dom -> getElementsByTagName('ConsumerCredit')->item(0);
	$pds[] = $dom -> createElement('PurchaseDscrpt');
	$pds[] = $dom -> createElement('PurchaseDscrpt');
	for ($i=0; $i<count($pds); $i++) {
		$pds[$i] -> appendChild($dom -> createElement('PDSNAME', 'INSURANCE'));
		$pds[$i] -> appendChild($dom -> createElement('PDSNBRUNITS', '1'));
		$pds[$i] -> appendChild($dom -> createElement('PDSUNITPRICE', $sum));
		$pds[$i] -> appendChild($dom -> createElement('PDCARYEAR', $absid));
		$pds[$i] -> appendChild($dom -> createElement('PDSTYPE', $i+1));
		$pds[$i] -> appendChild($dom -> createElement('PDSGOODSGROUP', 8));
		$pds[$i] -> appendChild($dom -> createElement('PDSGOODSCAT', $type));
		$pds[$i] -> appendChild($dom -> createElement('PDSINSURANCERATE', $rate));
		$ccd->appendChild($pds[$i]);
	}
}
function addOutCreditInsurance($dom, $absid, $type, $rate) {
	$ccd = $dom -> getElementsByTagName('ConsumerCredit')->item(0);
	$pds = $dom -> createElement('InsuranceCash');
	$pds -> appendChild($dom -> createElement('INSCGOODSTYPE', $type));
	$pds -> appendChild($dom -> createElement('INSCINSCOMID', $absid));
	$pds -> appendChild($dom -> createElement('INSCPRICE_RATE', $rate));
	$pds -> appendChild($dom -> createElement('INSCCLIENTAGREE', '1'));
	$pds -> appendChild($dom -> createElement('INSCCANCELLATION_OPTION', '1'));
	$ccd->appendChild($pds);
}
function setValue($node, $name, $value) {
	$nodes = $node-> getElementsByTagName($name);
	for ($i=0; $i<$nodes->length; $i++) {
		$nodes->item($i)->nodeValue = $value;
	}
}
function dom2dom($name, $src, $dst) {
	$nodesrc = $src -> getElementsByTagName($name)->item(0);
	$nodedst = $dst -> getElementsByTagName($name)->item(0);
	$nodedst->nodeValue = $nodesrc->nodeValue;
}


function generate($nodes, $params) {
	global $HELPER;
	for ($i=0;$i<$nodes->length; $i++) {
		if ($params['isnumeric']) {
			if (($params['name'] == 'DOCSR')&&($i==1)) {
				$params['mindigit'] = 2;
				$params['maxdigit'] = 2;
			}
			if (($params['name'] == 'DOCNUM')&&($i==1)) {
				$params['mindigit'] = 7;
				$params['maxdigit'] = 7;
			}
		 	$params['value'] = mt_rand(pow(10, $params['mindigit']-1), pow(10, $params['maxdigit'])-1);
		} else {
			$chars = "¿¡¬√ƒ≈∆«»… ÀÃÕŒœ–—“”‘’÷◊ÿŸ›ﬁﬂ";
			if ($params['name'] == 'ACCEMBASSINGNAME') {
				$chars = "ABCDEFGHIJKLNMOPQRSTUVWXYZ";
			}
			$length = mt_rand($params['mindigit'], $params['maxdigit']);
			$params['value'] = '';
			for ($j=0; $j<$length;$j++) {
				$params['value'] .= $chars[mt_rand(0, strlen($chars))];
			}
			if ($params['name'] == 'ACCEMBASSINGNAME') {
				$params['value'][mt_rand(3, $length-3)]=' ';
			}
			$params['value'] = $HELPER->toutf($params['value']);
		}
		$nodes->item($i) -> nodeValue=$params['value'];
	}
}

function generateCRB ($data) {
	global $HELPER;
	$contactAddress = array(
		'apartmentNumber' => rand_value(1, 150),
		'propertyStatus' => 1,
		'region' => rand_value(1, 89),
		'street' => rand_value(6,15, 3),	
		'streetNumber' => rand_value(1, 150),
		'streetType' => rand_value(1, 70),
		'timeOfLivingInMonths' => rand_value(12, 60),
		'town' => rand_value(5, 15, 3),
		'townType' => rand_value(1, 51),
		'zipCode' => rand_value(6, 6, 2)
		);
	$majorAddress = array(
		'apartmentNumber' => rand_value(1, 150),
		'propertyStatus' => 1,
		'region' => rand_value(1, 89),
		'street' => rand_value(6,15, 3),	
		'streetNumber' => rand_value(1, 150),
		'streetType' => rand_value(1, 70),
		'timeOfLivingInMonths' => rand_value(12, 60),
		'town' => rand_value(5, 15, 3),
		'townType' => rand_value(1, 51),
		'zipCode' => rand_value(6, 6, 2)
		);
	$mobilePhone = array (
		'number' => '9'.rand_value(2, 2, 2),
		'phoneNumber' => rand_value(7, 7, 2)
		);
	$homePhone = array (
		'number' => rand_value(3, 3, 2),
		'phoneNumber' => rand_value(7, 7, 2)
		);
	$workPhone = array (
		'number' => rand_value(3, 3, 2),
		'phoneNumber' => rand_value(7, 7, 2)
		);
	$document1 = array (
		'documentNumber' => rand_value(4, 4, 2),
		'documentSerialNumber' => rand_value(6, 6, 2),
		'documentType' => 1,
		'issueDate' => rand_date(2,7),
		'issuedBy' => rand_value(5, 15, 3)
		);
	$employerAddress = array (
		'propertyStatus' => 0,
		'region' => rand_value(1, 89),
		'street' => rand_value(6,15, 3),	
		'streetNumber' => rand_value(1, 150),
		'streetType' => rand_value(1, 70),
		'timeOfLivingInMonths' => 0,
		'town' => rand_value(5, 15, 3),
		'townType' => rand_value(1, 51),
		'zipCode' => rand_value(6, 6, 2)
		);
	$employment = array(
	    	'activitiesType' => 4,
                'employeeFrom' => str_replace('.', '-', rand_date(5,10)),
                'employerAddress' => $employerAddress,
                'employerName' => rand_value(5, 15, 3),
                'employerPhone' => array(
                		'number'=>$workPhone['number'],
                		'phoneNumber'=>$workPhone['phoneNumber']
                		),
                'occupation' => rand_value(3, 7, 3),
                'occupationType' => 5
		);
	$borrower = array(
		'contactAddress' => $contactAddress,
		'majorAddress' => $majorAddress,
		'mobilePhone' => $mobilePhone,
		'homePhone' => $homePhone,
		'workPhone' => $workPhone,
		'document1' => $document1,
		'employment' => $employment,
		'firstName' => rand_value(5, 15, 3),
		'middleName' => rand_value(5, 15, 3),
		'lastName' => rand_value(5, 15, 3),
		'motherLastName' => rand_value(5, 15, 3),
		'monthlyIncomeInRub' =>  rand_value(50, 90).'000',
		'secondMonthlyIncomeInRub' => 0,
		'birthDate' => rand_date(25,45),
		'birthPlace' => rand_value(5, 15, 3),
		'education' => rand_value(6,9),
		'familyState' => rand_value(0,1),
		'incomeType' => 1,
		'sex' => rand_value(0,1)
		);
	//$contactPerson1 = array();
	//$contactPerson2 = array();
	$goods = array(
		'category' => 57,
		'group' => 8,
		'name' => $HELPER->toutf('“Ó‚‡'),
		'unitPriceInRub' => $data['amount'],
		'unitsNumber' => 1
		);
	$application['application'] = array(
		'borrower' => $borrower,
		//'contactPerson1' => $contactPerson1,
		//'contactPerson2' => $contactPerson2,
		'goods' => $goods,
		'creditProductId' => $data['product'],
		'creditPeriodInMonths' => $data['term'],
		'initialPayment'=>$data['dp'],
		'posId'=>$data['posid'],
		'userLogin'=>$data['operator']
		);
	//TEMP
	$application['application'] ['insuranceSumInRub'] = 500.0;
	/*
	for ($i=0; $i<count($data['ins']); $i++ ) {
		if ($data['ins'][$i][1]>20000) {
			$goods[] = array(
				'category' => $data['ins'][$i][1],
				'group' => 2,
				'name' => '—Ú‡ıÓ‚Í‡',
				'unitPriceInRub' => ($data['amount'] - $data['dp']*$data['amount'])*$data['ins'][$i][2]*12/100,
				'unitsNumber' => 1
				);
		} else {
			$application['insuranceSumInRub'] = 500.0;
		}
	}*/
	return $application;
}

function rand_date($min, $max) {
	return date('Y')-rand_value($min,$max).'.'.rand_value(10,12).'.'.rand_value(10,28).' 00:00:00';
}

function rand_value($min, $max, $mode=1, $chars='RU') {
	$ruchars = "¿¡¬√ƒ≈∆«»… ÀÃÕŒœ–—“”‘’÷◊ÿŸ›ﬁﬂ";
	$engchars = "ABCDEFGHIJKLNMOPQRSTUVWXYZ";
	$value = '';
	global $HELPER;
	switch ($mode) {
		case 1:
			$value = mt_rand($min, $max);
			break;
		case 2:
			$value = mt_rand(pow(10, $min-1), pow(10, $max)-1);
			break;
		case 3:
			$length = mt_rand($min, $max);
			for ($j=0; $j<$length;$j++) {
				$value .= $ruchars[mt_rand(0, strlen($ruchars))];
			}
			$value = $HELPER->toutf($value);
			break;
		case 4:
			$length = mt_rand($min, $max);
			for ($j=0; $j<$length;$j++) {
				$value .= $engchars[mt_rand(0, strlen($engchars))];
			}
			break;
	}
	return $value;
}
$head = '<?xml version="1.0" encoding="utf-8"?><Application_Type xmlns="http://rccf.ru/loanOrigination">';
$foot = '</Application_Type>';
$template = './config/app.xml';
$url = 'http://'.$currentdep['props']['lofacadehost'].':'.$currentdep['props']['lofacadeport'].'/LoanOriginationFacadeModuleWeb/sca/LoanOriginationFacade2Export';
$crburl = 'http://'.$currentdep['props']['lofacadehost'].':'.$currentdep['props']['lofacadeport'].'/CRBFacadeModuleWeb/sca/SecureLoanExport1';
$wsdl = 'config/LoanOriginationFacade2Export.wsdl';
$crbwsdl = 'config/SecureLoan.wsdl';
$copy = array('HNCID', 'RCLRCRDID', 'RCLDATERCVD', 'RCLDATERCVDSYS', 'RCLDATERCVDTEXT', 
'ACTPRODCODE', 'APPPOSID', 'APPPRODUCTGROUP', 'ACTDATECREATE', 'DECTIME', 'CQUEUESTATE', 'CQUEUESTATECODE');
$random = array(
	array (
		'name' => 'DOCSR',
		'mindigit' => 4,
		'maxdigit' => 4,
		'isnumeric'=> true
		),
	array (
		'name' => 'DOCNUM',
		'mindigit' => 6,
		'maxdigit' => 6,
		'isnumeric'=> true
		),
	array (
		'name' => 'ADRPSTLCODE',
		'mindigit' => 6,
		'maxdigit' => 6,
		'isnumeric'=> true
		),
	array (
		'name' => 'EMPWORKTELNBR',
		'mindigit' => 7,
		'maxdigit' => 7,
		'isnumeric'=> true
		),
	array (
		'name' => 'TELPHONE',
		'mindigit' => 7,
		'maxdigit' => 7,
		'isnumeric'=> true
		),
	array (
		'name' => 'ADRSTRTNAME',
		'mindigit' => 6,
		'maxdigit' => 15,
		'isnumeric'=> false
		),
	array (
		'name' => 'DOCISSUEWHO',
		'mindigit' => 9,
		'maxdigit' => 9,
		'isnumeric'=> false
		),
	array (
		'name' => 'EMPTITLE',
		'mindigit' => 9,
		'maxdigit' => 9,
		'isnumeric'=> false
		),
	array (
		'name' => 'PRSNAMELAST',
		'mindigit' => 5,
		'maxdigit' => 20,
		'isnumeric'=> false
		),
	array (
		'name' => 'PRSNAMEFIRST',
		'mindigit' => 9,
		'maxdigit' => 9,
		'isnumeric'=> false
		),
	array (
		'name' => 'PRSNAMEMDDL',
		'mindigit' => 9,
		'maxdigit' => 9,
		'isnumeric'=> false
		),
	array (
		'name' => 'PRSSCRTYID',
		'mindigit' => 9,
		'maxdigit' => 9,
		'isnumeric'=> false
		),
	array (
		'name' => 'PRSPOB',
		'mindigit' => 6,
		'maxdigit' => 15,
		'isnumeric'=> false
		),
	array (
		'name' => 'ACCEMBASSINGNAME',
		'mindigit' => 10,
		'maxdigit' => 20,
		'isnumeric'=> false
		),
	);
?>
