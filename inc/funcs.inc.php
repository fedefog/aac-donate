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
?>