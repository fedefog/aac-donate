<?php

function GetVal($nodeName, $nodeList = null) {
    if ($nodeList == null) {
        global $record;
        $nodeList = & $record;
    }

    if (!$nodeList)
        return '';
    $node = & $nodeList->getElementsByTagName($nodeName);
    if ($node && $node->getLength()) {
        $o = $node->item(0);
        return $o->getText(); ///$node->toNormalizedString();					
    } else
        return '';
}

function mask($str, $start = 0, $length = null) {
    $mask = preg_replace("/\S/", "*", $str);
    if (is_null($length)) {
        $mask = substr($mask, $start);
        $str = substr_replace($str, $mask, $start);
    } else {
        $mask = substr($mask, $start, $length);
        $str = substr_replace($str, $mask, $start, $length);
    }
    return $str;
}

function getTransactionType($code) {
    $type = "";
    if ($code == "VO") {
        $type = "Voucher";
    } else if ($code == "SO") {
        $type = "Standing Order";
    } else if ($code == "PEN") {
        $type = "Pending";
    } else if ($code == "Cd") {
        $type = "Company Donation";
    } else if ($code == "CO") {
        $type = "Commission";
    } else if ($code == "Q") {
        $type = "Debit";
    } else if ($code == "RF") {
        $type = "Refund";
    } else if ($code == "TA") {
        $type = "Tax Refund";
    } else if ($code == "Ch") {
        $type = "Charity Donation";
    } else if ($code == "Gi") {
        $type = "Gift Aid";
    } else if ($code == "Gy") {
        $type = "Give As You Earn";
    } else if ($code == "Ng") {
        $type = "Non Gift Aid";
    } else if ($code == "NV") {
        $type = "NV";
    }
    return $type;
}
function getTransactionColor($code) {
    $color_class = "";
    if ($code == "VO") {
        $color_class = "balance-down";
    } else if ($code == "SO") {
        $color_class = "balance-down";
    } else if ($code == "PEN") {
        $color_class = "balance-pending";
    } else if ($code == "Cd") {
        $color_class = "balance-up";
    } else if ($code == "CO") {
        $color_class = "balance-down";
    } else if ($code == "Q") {
        $color_class = "balance-down";
    } else if ($code == "RF") {
        $color_class = "balance-down";
    } else if ($code == "TA") {
        $color_class = "balance-down";
    } else if ($code == "Ch") {
        $color_class = "balance-up";
    } else if ($code == "Gi") {
        $color_class = "balance-up";
    } else if ($code == "Gy") {
        $color_class = "balance-up";
    } else if ($code == "Ng") {
        $color_class = "balance-down";
    } else if ($code == "NV") {
        $color_class = "balance-down";
    }else{
        $color_class = "balance-down";
    }
    return $color_class;
}

function getBalanceColor($amount) {
    $color_class = "";
    if($amount > 0){
        $color_class = "balance-up";
    }else if($amount < 0){
        $color_class = "balance-down";
    }
    return $color_class;
}

function showBalance($amount){
    if($amount > 0){
        return '£ '.number_format($amount, 2);
    }else if($amount < 0){
        return '- £ '.abs(number_format($amount, 2));
    }
}

function showInterval($interval) {
    if ($interval == "M") {
        return 'Month';
    } else if ($interval == "2") {
        return '2 Months';
    } else if ($interval == "3") {
        return '3 Months';
    }
}

function AjaxCheck() {		
	$isInclude = defined('IS_INCLUDE') && IS_INCLUDE;
	if(!$_REQUEST['ajax'] && !$isInclude){
		$thisPage = substr($_SERVER['REQUEST_URI'],strlen(SITE_ROOT)); //basename($_SERVER['PHP_SELF']);
		include 'index.php';
		exit;
		//header('location:index.php#'.$_SERVER['PHP_SELF'].http_build_query($_GET));
		//exit;
	}
}


function buildDates($key,$search){
	//global $search;

	$search2 = $search;



	if($key!='custom' && $key !='alltime') {
		$search2['startdate'] = date('d-m-Y',strtotime('-'.$key));
		$search2['enddate'] = date('d-m-Y');
		$key = str_replace(' ','',$key);
	}

	$search2['dateType']=$key;

	$params = http_build_query($search2);

	$result = array(
		'url'=>'transactions.php?'.$params,
		'startdate'=>$search2['startdate'],
		'enddate'=>$search2['enddate'],
		'dateType'=>$key
	);

//var_dump($result);

	return $result;

}

					function showFilter($key,$search){
					//	global $search;


						$labels = array(
							'searchstr'=>'Quick Search',
							'transaction_id'=>'NO',
							'charity_name'=>'CHARITY',
							'amount_donated'=>'AMOUNT',
							'personal_note'=>'NOTE',
							'voucher_no'=>'VOUCHER',
							'book_voucher_no'=>'BOOK',
							'transaction_type'=>'TYPE',
							'dates'=>'DATE',
						);

						$value = '';
						$search2 = $search;
						if($_REQUEST['type']) $search2['type'] = $_REQUEST['type'];

						if($key=='amount_donated') {
							if($search['amount_donated_from'] && $search['amount_donated_to']) 
								$value = "&pound;{$search['amount_donated_from']} TO &pound;{$search['amount_donated_to']}";
							else if($search['amount_donated_from'])
								$value = "&pound;{$search['amount_donated_from']}+";
							else if($search['amount_donated_to'])
								$value = "&pound;0-{$search['amount_donated_to']}";
							unset($search2['amount_donated_from']);
							unset($search2['amount_donated_to']);
						} else if($key=='voucher_no') {
							if($search['voucher_no_from'] && $search['voucher_no_to']) 
								$value = "{$search['voucher_no_from']} TO {$search['voucher_no_to']}";
							else if($search['voucher_no_from'])
								$value = "{$search['voucher_no_from']}+";
							else if($search['voucher_no_to'])
								$value = "0-{$search['voucher_no_to']}";
							unset($search2['voucher_no_from']);
							unset($search2['voucher_no_to']);
						} else if($key=='dates') {
							if($search['startdate'] && $search['enddate']) 
								$value = "{$search['startdate']} TO {$search['enddate']}";

							unset($search2['startdate']);
							unset($search2['enddate']);							
							unset($search2['dateType']);						
						} else if($key=='transaction_type') {	
							$types = TransactionList::GetTransactionTypes();
//var_dump($types).$value;
							$value = $types[$search[$key]];
							unset($search2[$key]);							
						} else {
							$value = $search[$key];
							unset($search2[$key]);
						}

						if(!$value) return;

						$label = $labels[$key];
						$params = http_build_query($search2);
					
						?>
	                    <span class="filter-selected"><a href="transactions.php?<?php echo $params ?>">x</a><?php echo "{$label}: $value" ?></span>
						<?php	

					}

					function IsCurrentSortDesc($field,$direction,$request=null) {

						if(!$request) $request = $_REQUEST;
						if(!$direction) $direction = $request['sort'];
						if(!$direction) $direction = 'ASC';
	
						if( ($field==$request['fieldname']) && (strtoupper($direction)=='DESC') ) return true;
						else return false;
					}

					function IsCurrentSortField($field, $request=null) {

						if(!$request) $request = $_REQUEST;
	
						if($field==$request['fieldname']) return true;
						else return false;
					}

					function CheckCurrentSort($field,$request) {

						if(!$request) $request = $_REQUEST;

						$return = '';
						
						if(IsCurrentSortField($field,$request))
							$return .= ' green ';

						if (IsCurrentSortDesc($field,null,$request)){
							$return .= 'fa-caret-up';
						} else {
							$return .= 'fa-caret-down';
						}
				
						return $return;
						
					}

					function BuildSortLink($field,$direction=null,$request=null){

						if(!$request) $request = $_REQUEST;

						$paramArray = $request;
						unset($paramArray['fieldname']);
						unset($paramArray['sort']);
						unset($paramArray['ajax']);
						$params= http_build_query($paramArray);
						if($params) $params = "&amp;$params";

						if(!IsCurrentSortField($field,$request) || IsCurrentSortDesc($field,$direction,$request))
							return "fieldname={$field}&amp;sort=ASC{$params}";
						else
							return "fieldname={$field}&amp;sort=DESC{$params}";
					}

function VBValue($value) {
	return $value?$value:0;
}

?>