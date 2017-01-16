<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'cls/vouchers.cls.php';
require_once 'cls/charities.cls.php';
require_once 'cls/ui.cls.php';
require_once 'cls/aac_requests.cls.php';
require_once 'cls/sendmail.cls.php';
require_once 'cls/class.smtp.php';
require_once 'cls/class.phpmailer.php';
require_once 'cls/emails.cls.php';
require_once 'cls/emaillog.cls.php';
require_once 'inc/funcs.inc.php';
session_start();
User::LoginCheck();
$user = new User();
$user = User::GetInstance();


$req_charity_id = mysql_real_escape_string((empty($_REQUEST['charityId'])) ? "" : $_REQUEST['charityId']);
$req_id = mysql_real_escape_string((empty($_REQUEST['id'])) ? "" : $_REQUEST['id']);
$req_amount = mysql_real_escape_string((empty($_REQUEST['amount'])) ? "" : $_REQUEST['amount']);
$somid = mysql_real_escape_string((empty($_REQUEST['SOMID'])) ? "" : $_REQUEST['SOMID']);

$request = new AACRequestItem();
$td = new TransactionDetailList();
$transaction = $td->getTransactionDetailByAccountName($user->Reference);
foreach ($transaction as $tr) {
    $balance = $tr->Close_balance;
    $account = $tr->acc;
    $date = $tr->dt;
}
$balance = $balance ? $balance : 0;

if($req_id) {
	if($request->load($req_id)) {
		if($request->Username != $user->Username) die('Access denied');
		$fields = $request->GetProperties();
	}
} else if($somid) {
	$som = new StandingOrderMasterItem();
	if($som->load($somid)) {
		if($som->account != (int)$user->Username) die('Access denied');		

		$fields = array(
			'Beneficiary' => $som->name,
			'RemoteCharityID' => $som->charity_id,
			'Amount' => $som->amount,
			'StandingOrderType'=>$som->mode=='C'?'Fixed number of payments':'Continuous payments', //Fixed number of payments / Continuous payments
			'NumberOfPayments'=>$som->times,
			'StandingOrderStartDate'=>date('1 M Y'),
			'StandingOrderFrequency'=>'Every Month', //Every Month /  Every 2 months / Every 3 months			
			'OfficeComments'=>$som->notes_to_aac,
			'ClientComments'=>$som->notes_to_charity,
			'UserComments'=>$som->notes_to_self,
		);

		if($som->freq=='2') $fields['StandingOrderFrequency'] = 'Every 2 months';
		if($som->freq=='Q') $fields['StandingOrderFrequency'] = 'Every 3 months';

		//freq

		if($_REQUEST['repeat']) unset($somid);

	} else die('Unable to locate standing order');
}
//var_dump($fields);

if($req_charity_id) {
	$charity = new CharityItem();
	if($charity->loadByRemoteID($req_charity_id)) {
//var_dump($charity);
		$fields['Beneficiary'] = $charity->Name;
		$fields['RemoteCharityID'] = $req_charity_id;
	}
}
if($req_amount) $fields['Amount'] = $req_amount;



/* $qry = "";
  $qry .= "select * from charities where remote_charity_id = " . $req_charity_id;
  $result = mysql_query($qry);
  $row = mysql_fetch_row($result);
  $charity_name = $row[3]; */
/******************
if ($req_charity_id != "" && $req_charity_id > 0) {
    $transactionlist = new TransactionList();
    $charity_row = $transactionlist->getCharityList($req_charity_id);
    $charity_name = $charity_row[0]->Name;
    $fields['RemoteCharityID'] = $req_charity_id;
}
****************/
/* $qry = "";
  $qry .= "SELECT * FROM aac_requests ";
  $qry .= "WHERE id = " . $req_id;
  $result = mysql_query($qry);
  $row = mysql_fetch_row($result, 1); */
/*********************************
if ($req_id != "" && $req_id > 0) {
    $transactionlist = new TransactionList();
    $row = $transactionlist->getAACRequestList($req_id);
}
//echo $qry;


if ($_REQUEST['Request']) {
    $fields['Request'] = $_REQUEST['Request'];
    $fields['Beneficiary'];
} else {
    $fields = $_REQUEST;
    $fields['Request'] = 'Initiate Transfer';
    if($req_charity_id) $fields['RemoteCharityID'] = $req_charity_id;
}
if ($_POST['doAction']) {
    if ($_POST['request_id'] != "") {
        echo 'edit';
        exit;
        //edit code here
    }

    $fields = $_REQUEST['fields'];
    $error = '';
    if ($_REQUEST['my-checkbox'] != 'on') {
        $fields['StandingOrderType'] = $_REQUEST['StandingOrderType'];
        $fields['NumberOfPayments'] = $_REQUEST['NumberOfPayments'];
        $fields['StandingOrderFrequency'] = "No";
        $fields['StandingOrderStartDate'] = $_REQUEST['startdate'];
    }
    //unset($fields['StandingOrderType']);
    switch ($fields['Request']) {
        case 'Initiate Transfer':

            $fields['Amount'] = abs($fields['Amount']);
            if (!$fields['Beneficiary'] || $fields['Beneficiary'] == 'Please select charity from list')
                $error = 'Please select a Beneficiary';
            else if (!$fields['Amount'])
                $error = 'Please enter an amount';
            else if (!is_numeric($fields['Amount']))
                $error = 'Amount must be a number';
            else if (!$_REQUEST['ConfirmTransfer'])
                $error = 'Please confirm the transaction is charitable';
            else if ($fields['StandingOrderFrequency'] != 'No' && !$fields['StandingOrderStartDate'])
                $error = 'Please enter a standing order start date';
            $NIS_exrate = NIS_EXRATE;
            $USD_exrate = USD_EXRATE;
            $EUR_exrate = EUR_EXRATE;
            $gbpAmount = 0;
            if ($fields['Currency'] == 'GBP' || !$fields['Currency'] || !$fields['Amount']) {
                
            } else if ($fields['Currency'] == 'EUR') {
                $gbpAmount = $fields['Amount'] / $EUR_exrate;
            } else if ($fields['Currency'] == 'USD') {
                $gbpAmount = $fields['Amount'] / $USD_exrate;
            } else if ($fields['Currency'] == 'NIS') {
                $gbpAmount = $fields['Amount'] / $NIS_exrate;
            }
            if ($_REQUEST['charityRemoteID']) {
                $fields['RemoteCharityID'] = $_REQUEST['charityRemoteID'];
                $charity = new CharityItem();
                if ($charity->LoadByColumnName($fields['Beneficiary'], 'Name')) {
                    $RemoteCharityCountry = $charity->CountryName;
                }
            } else {
                $charity = new CharityItem();
                if ($charity->LoadByColumnName($fields['Beneficiary'], 'Name')) {

                    $fields['RemoteCharityID'] = $charity->remote_charity_id;
                    $RemoteCharityCountry = $charity->CountryName;
                } else
                    $fields['RemoteCharityID'] = -2;
            }
            if ($RemoteCharityCountry && (strtoupper(trim($RemoteCharityCountry)) != 'UK'))
                $fields['OfficeComments'] .= "\nCountry: " . $RemoteCharityCountry;
            if ($gbpAmount) {
                $gbpAmount = round($gbpAmount, 2);
                $gbpAmountF = number_format($gbpAmount, 2);
                $fields['OfficeComments'] .= "\nEstimated GBP Amount " . utf8_decode('�') . $gbpAmountF;
                $fields['GBPAmount'] = $gbpAmount;
            } else
                $fields['GBPAmount'] = $fields['Amount'];
            $fields['OfficeComments'] = trim($fields['OfficeComments'], "\n");
            break;
    }
    if (!$error) {
        $request->Username = $user->Username;
        if (!$id) {
            $request->ResultCode = 'Pending';
            $request->RequestDateTime = time();
        }
        if ($fields['VoucherBooks'] && is_array($fields['VoucherBooks']) && count($fields['VoucherBooks'])) {
            $vb = '';
            foreach ($fields['VoucherBooks'] as $vbook => $qty) {
                if (!$qty)
                    continue;
                $vbook = utf8_decode(html_entity_decode($vbook));
                $vb .= "{$qty}x{$vbook}; ";
            }
            $fields['VoucherBooks'] = trim($vb, ' ;');
        }
        $fields['StandingOrderStartDate'] = $fields['StandingOrderStartDate'] ? strtotime($fields['StandingOrderStartDate']) + 3600 : '0';
        $fields['StandingOrderEndDate'] = $fields['StandingOrderEndDate'] ? intval($fields['StandingOrderEndDate']) + 3600 : '0';
        $fields['System'] = 'Desktop';
//        print_r($fields);
//        exit;
        $request->SetProperties($fields);
        $request->UpdateSummary();
        $request->VoucherBookUrgent = $request->VoucherBookUrgent ? 'Yes' : 'No';

        $request->Save();
        UI::Redirect('index.php');
        //email send to client
        //$emails = new AchisomochEmails();
        //$emails->SendRequestConfirmations($user, $request);
        $details = "Request: " . $fields['Request'];
        if ($fields['StandingOrderFrequency'] && $fields['StandingOrderFrequency'] != 'No')
            $details .= ' : Standing Order';
        if ($_POST['clone'])
            $details .= ' : Re-Request';
        User::LogAccessRequest($user->Username, '', $details);
        UI::Redirect('?done=true');
    }
} else if (!$_REQUEST['done'] && !$id) {
    $details = "New Request: " . $fields['Request'];
    User::LogAccessRequest($user->Username, '', $details);
}

switch ($fields['Request']) {
    case 'Initiate Transfer':
        $field_list = array('BeneficiaryField', 'AmountField', 'StandingOrderField');
        break;
    default:
        die('Unknown request');
        $field_list = array();
}
$fields['Beneficiary'] = $_REQUEST['Beneficiary'];
$fields['Amount'] = $_REQUEST['Amount'];
**************************/

?>
<script language="javascript" src="js/date.js"></script>
<script type="text/javascript">
    var currencyWarningShown = false;
    var selectedCharityCountry = '<?php echo trim($RemoteCharityCountry) ?>';
    $(document).ready(function () {

		$('.autocomplete-charities').autocomplete({
			source: 'remote.php?m=getCharityList',
		    messages: {
		        noResults: '',
		        results: function() {}
		    },
			resultTextLocator:'label',
			select: function(event, ui){
				event.preventDefault();
				$('.autocomplete-charities').val(ui.item.name);
				/**
				if(ui.item.address!=''){
					$('#charityAddressBox').show();
					$('#charityAddressBoxData').html(ui.item.address);
				} else
					$('#charityAddressBox').hide();
				**/

				DoCharityChange();

			}
		});

        if (jQuery('#request_id').val() !== '') {
            jQuery('#hidden_allow').val('1');
        }

        jQuery("#Beneficiary").keyup(function () {
            jQuery('#hidden_allow').val('0');
            var filter = jQuery(this).val().toLowerCase();
            jQuery(".results li").each(function () {
                var x = jQuery(this).text().toLowerCase();
                if (x.indexOf(filter) != -1) {
                    jQuery(this).show();
                } else {
                    jQuery(this).hide();
                }
            });
        });
        jQuery(document).on('click', '.results li', function () {
            jQuery('#hidden_allow').val('1');
        });
        //alert(jQuery("#Beneficiary").val());
        if (jQuery("#Beneficiary").val() !== "") {
            jQuery('#history').text("See previous donations to <?php echo $fields['Beneficiary']; ?>").css({opacity: 1});
            jQuery('#history').prop('href', "transactions-history.php?charityId=<?php echo $fields['RemoteCharityID']; ?>");
            jQuery('.beneficiary-select-error').css({display: 'block'});
        }

<?php
/**
if ($_REQUEST['id'] != "") {
    ?>
            jQuery('#history').text("See previous donations to <?php echo $row[0]->Beneficiary; ?>").css({opacity: 1});
            jQuery('#history').prop('href', "transactions-history.php?charityId=<?php echo $req_id; ?>");
    <?php
}
**/
?>
    });
    var NIS_exrate = <?php echo NIS_EXRATE; ?>;
    var USD_exrate = <?php echo USD_EXRATE; ?>;
    var EUR_exrate = <?php echo EUR_EXRATE; ?>;
    function DoCharityChange()
    {
        var charityName = $('#Beneficiary').val();
        var strplus = "See previous donations to " + charityName;
        var strplusNone = "You haven't made any previous donations to " + charityName;
        //var link = encodeURI(charityId);
        //$('#history').prop('href', "transactions-history.php?charityname=" + link);
        $.ajax({
            dataType: 'json',
            url: 'remote.php?m=getCharityDetail&charityName=' + encodeURIComponent(charityName),
            success: function (data) {
                //alert(JSON.stringify(data));
                if (data.found == 1) {
                    $('#charityAddressBox').show();
                    $('#charityAddressBoxData').html(data.address);
                    $('#charityRemoteID').val(data.remoteCharityID);

					if(parseInt(data.donationCount))
	                    $('#history').text(strplus).css({opacity: 1});
					else
	                    $('#history').text(strplusNone).css({opacity: 1});
                    $('#history').prop('href', "transactions-history.php?charityId=" + data.remoteCharityID);

                    selectedCharityCountry = data.countryName;
                    if ($.trim(data.countryName) == 'UK') {
                        $('#profile').css({opacity: 1});
                    } else {
                        $('#profile').css({opacity: 0});
                    }
                } else
                    $('#charityAddressBox').hide();
            }
        });

        DoCurrencyList();
    }

    function DoCurrencyList() {
        $('#gbpAmountBoxData').hide();
        var charityName = $('#Beneficiary').val();
        $.ajax({
            url: 'remote.php?m=getCurrencyCodes&charityName=' + encodeURIComponent(charityName),
            success: function (data) {
                if (data == '') {
                    $('.selectpicker').selectpicker('refresh');
                } else {
                    $('#Currency').html(data);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    }

    function confirmTransfer() {
        console.log("confirmTransfer");
        if ($('.ConfirmTransfer').hasClass('active')) {
            document.getElementById("ConfirmTransfer").value = '';
        } else {
            $('#cnfdonation').removeClass('has-error');
            document.getElementById("ConfirmTransfer").value = '1';
        }
    }

    function UpdateStandingOrderContinuousCaption()
    {
        var startdate = '1 ' + $('#StandingOrderStartDate').val();
        var payint = $('#StandingOrderFrequency').val();
        if (payint == '' || startdate == '')
            return;
        $('#StandingOrderEndDate').val('');
        var monthPeriod = payint;
        /*var monthPeriod = payint.replace('Monthly', 'months');
         if (monthPeriod == 'months')
         monthPeriod = 'month';*/
        var d = new Date(startdate);
        $('#StandingOrderInfoContinuous').show();
        $('#StandingOrderInfoContinuous').html(monthPeriod + ' from ' + d.toDateString() + ', continuously ');
        //$('#StandingOrderInfoContinuous').html('Every ' + monthPeriod + ' from ' + d.toDateString() + ', continuously ');
    }

    function UpdateStandingOrderFixedCaption() {
        var numpay = 2;
        var startdate = $('#StandingOrderStartDate').val();
        var payint = $('#StandingOrderFrequency').val();
        if (numpay <= 1) {
            jQuery("#modal-quick-donation p").html('Standing orders must be for at least 2 payments');
            jQuery("#modal-quick-donation").modal('show');
            return;
        }
        if (numpay > 1)
            numpay = numpay - 1;

        if (numpay == 'NaN' || isNaN(numpay) || numpay == 0)
            numpay = '';

        if (payint == '' || numpay == '' || startdate == '')
            return;

        var monthInc;
        var months;

        if (payint == 'Every Month')
            monthInc = 1;
        else if (payint == 'Every 2 months')
            monthInc = 2;
        else if (payint == 'Every 3 months')
            monthInc = 3;

        var monthPeriod = payint;
        //var monthPeriod = payint.replace('Monthly', 'months');
        /*if (monthPeriod == 'months')
         monthPeriod = 'month';*/

        months = (numpay * monthInc);
        var sd = new Date(startdate);
        var d = new Date(startdate);
        var endDate = d.add(months).month();
        $('#StandingOrderEndDate').val(endDate.getTime() / 1000);
    }

    function TestNumber(amount) {
        if (isNaN(amount))
            return false;
        var arr = amount.split('.');
        if (arr.length == 2) {
            var length = arr[1].length;
            if (length > 2)
                return false;
        }
        return true;
    }


    jQuery(document).ready(function () {
        $('#StandingOrderType,#StandingOrderStartDate,#StandingOrderFrequency').on('change', function () {
            var v = $("#StandingOrderType").val();
            if (v == 'No') {
            } else if (v == 'Fixed number of payments') {
                UpdateStandingOrderFixedCaption();
            } else if (v == 'Continuous payments') {
                UpdateStandingOrderContinuousCaption();
            }
        });
        jQuery("#Currency").on('shown.bs.select', function () {

        });
        jQuery('#Amount, #Currency').on('change ', function () {
            var amount = $('#Amount').val();
            var currency = $('#Currency').val();
            var gbpAmount = 0;
            if (currency == 'GBP' || !currency || !amount) {
                $('#gbpAmountBoxData').hide();
                return false;
            } else if (currency == 'EUR') {
                gbpAmount = amount / EUR_exrate;
            } else if (currency == 'USD') {
                gbpAmount = amount / USD_exrate;
            } else if (currency == 'NIS') {
                gbpAmount = amount / NIS_exrate;
            }
            $('#gbpAmountBoxData').html(gbpAmount.toFixed(2) + ' GBP');
            $('#gbpAmountBoxData').show();
        });

        jQuery('#lblNumberOfPayments').show();
        jQuery('#txtNumberOfPayments').show();
        //jQuery('#txtNumberOfPayments').attr("disabled", "disabled"); 
        jQuery('#StandingOrderType').on('change ', function () {
            if (jQuery('#StandingOrderType').val() !== "Fixed number of payments") {
                jQuery('#lblNumberOfPayments').hide();
                jQuery('#txtNumberOfPayments').hide();
            } else {
                jQuery('#lblNumberOfPayments').show();
                jQuery('#txtNumberOfPayments').show();
            }
        });
        if (jQuery('.standing-order-switch-container').hasClass('active') === false) {
            jQuery('#txtNumberOfPayments').attr("disabled", "disabled");
        }
    });
    DoCurrencyList();
</script>
<?php if ($_REQUEST['done']) { ?>
    <p class="blue-text" style="text-align: center;left: 0;right: 0;position: absolute;font-size: 20px;">Your request has been sent.  <a href="index.php">Return to Main Page</a></p>
    <div style="height:150px"></div>
<?php } else { ?>
    <main class="main-transactions make-donation content-desktop">
        <form name="editor" id="editor" method="POST" action="<?php echo basename($_SERVER['PHP_SELF']) ?>" >	  
            <div class="header-fixed visible-xs">
                <header class="header ">
                    <div class="container ">
                        <div class="row">
                            <div class="header-mobile-transactions">
                                <div class="col-xs-2">
                                    <a href="dashboard.php" class="go-back">
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    </a>
                                </div><!-- /col -->
                                <div class="col-xs-8">
									<?php if($somid) { ?>
                                    <h2 class="title">Edit Standing Order</h2>
									<?php } else { ?>
                                    <h2 class="title">Make a Donation/Standing Order</h2>
									<?php } ?>
                                </div><!-- /col -->	
                                <div class="col-xs-2">
                                    <a href="#" class="nav-mobile nav-icon4 visible-xs ">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>
                                </div><!-- /col -->	
                            </div><!-- /header-mobile-transactions -->
                            <div class="clear"></div>

                        </div><!-- /row  -->	

                    </div><!-- /container  -->

                </header>

            </div><!-- /header-fixed -->

            <div class="container top-center-content">

                <div class="row">

                    <div class="col-xs-12">

                        <div class="box-account-header visible-xs">

                            <div class="box-account">

                                <h2 class="title">ACCOUNT</h2> 

                                <h3 class="account-number"><?php echo $account; ?></h3>

                            </div><!-- /box-account -->

                            <div class="box-balance">

                                <h2 class="title">BALANCE</h2>

                                <h3 class="balance-number">£ <?php echo $balance; ?></h3>

                            </div><!-- /box-balance -->

                        </div><!-- /box-account-header -->

                        <h3 class="time-update visible-xs">AS OF <strong><?php echo $date; ?></strong></h3>

                    </div><!-- / col 12 -->

                </div><!-- / row -->

            </div><!-- / top center content -->


            <div id="mobile-content-make-dontation" class="">
                <div class="box-slide-text">
                    <div class="container-fluid">
                        <?php
                        /* $qry = "";
                          $qry .= "select * from notes";
                          $result = mysql_query($qry);
                          $row_notes = mysql_fetch_row($result); */
                        $transactionlist = new TransactionList();
                        $notes_row = $transactionlist->getNotes();
                        ?>
                        <a href="javascript:void(0);" class="lkn-daily">
                            <p class="text"><?php echo substr(trim($notes_row[0]->TopTickerMessage), 0, 140); ?></p>
                            <!--<i class="fa fa-angle-down" aria-hidden="true"></i>
                            <i class="fa fa-angle-up" aria-hidden="true"></i>-->
                        </a>
                    </div><!-- container -->
                </div><!-- /box-daily-updates -->

                <div class="container-fluid visible no-padding-desktop">

                    <div class="row hidden-xs">
                        <div class="col-md-12">
									<?php if($somid) { ?>
                                    <h2 class="title-section-desktop">Edit Standing Order</h2>
									<?php } else { ?>
                                    <h2 class="title-section-desktop">Make a Donation/Standing Order</h2>
									<?php } ?>
                        </div>
                    </div>
                    <?php if ($error) { ?>
                        <tr>
                            <td class="error" colspan="2" style="padding-bottom:10px;text-align:center"><?php echo $error ?></td>
                        </tr>
                    <?php } ?>
                    <div class="row">
                        <!--Desktop-->
                        <div class="col-md-6 col-xs-12 border-right padding-right">
                            <div class="box-make-donation ">
                                <h2 class="title-make-donation">BENEFICIARY</h2>
                                <?php
								/**
                                $cl = new CharityList();
                                $charities = $cl->ListItems();

                                if ($row[0]->Beneficiary != "") {
                                    $fields['Beneficiary'] = $row[0]->Beneficiary;
                                } else if ($charity_name != "") {
                                    $fields['Beneficiary'] = $charity_name;
                                }
								**/
                                ?>
                                <input class="input-beneficiary autocomplete-charities form-control input-text" type="text" id="Beneficiary" name="fields[Beneficiary]" placeholder="Please select a Beneficiary" value="<?php echo $fields['Beneficiary']; ?>" <?php echo $somid?' disabled ':'' ?> />
								<?php /**
                                <div class="search" id="search">
                                    <span class="input-beneficiary caret" style="cursor:pointer;"></span>
                                    <input class="input-beneficiary" type="text" id="Beneficiary" name="fields[Beneficiary]" placeholder="Please select a Beneficiary" value="<?php echo $fields['Beneficiary']; ?>" />

                                    <ul class="results">
                                        <?php
                                        if (count($charities)) {
                                            foreach ($charities as $c) {
                                                ?>
                                                <li class="charity"><a href="#"><span><?php echo $c->Name; ?></span><br/></a></li>
                                                <?php
                                                // <li><a href="#"><span>GGBH</span><br />The Riding London NW11 8HL</a></li>
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
								**/ ?>
                                <p class="text-danger beneficiary-select-error">Please note: Achisomoch carries out random checks on the charitable status of the organisations mentioned on this list, However no guarantee is implied that all charities mentioned on this list are bona-fide.</p>

                                <div class="box-make-donation-lkns">
									<!--transactions-history.php?charityname=GGBH-->
                                    <a href="#" class="make-donation-lkns external-lkn" style='opacity: 0' id="history"></a>

                                    <a href="#" id="profile" class="make-donation-lkns" style='opacity: 0; display:none;'>Charity Commission profile</a>

                                </div>

                            </div><!-- /box-make-donation -->

                            <div class="box-make-donation">

                                <h2 class="title-make-donation">AMOUNT</h2>

                                <div class="amount-input ">
                                    <?php
									/**
                                    if ($row[0]->Amount != "") {
                                        $fields['Amount'] = $row[0]->Amount;
                                    }
									**/
                                    ?>
                                    <input type="text" name="fields[Amount]" id="Amount" class="form-control input-text" placeholder="Enter an amount" value="<?php echo $fields['Amount']; ?>">

                                    <span id="gbpAmountBoxData" class="numb-aprox"> </span>

                                </div><!-- /amount-input -->

                                <?php
                                $options = array();
								/**
                                if ($request->id) {
                                    $beneficiary = $request->Beneficiary;
                                } else if (is_array($charities)) {
                                    $c = reset($charities);
                                    $beneficiary = $c->Name;
                                } else
                                    $beneficiary = '';
								**/
								$beneficiary = $fields['Beneficiary'];
                                if ($beneficiary) {
                                    $ccl = new CharityCurrencyList();
                                    $ccl_items = $ccl->GetCurrencyCodesByCurrencyName($beneficiary);
                                    if (count($ccl_items))
                                        foreach ($ccl_items as $i)
                                            $options[] = $i->CurrencyCode;
                                } else {
                                    $options[] = 'GBP';
                                }
                                ?>
                                <div class="coin-amount">
                                    <select name="fields[Currency]" id="Currency" class = "form-control selectpicker" onselect="DoCurrencyList();">
                                        <?php
                                        foreach ($options as $op) {
                                            $sel = "";
                                            if ($op == $fields['Currency']) {
                                                $sel = "selected";
                                            }
                                            ?>
                                            <option value="<?php echo $op; ?>" <?php echo $sel; ?>><?php echo $op; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div><!-- /coin-amount -->
                                <p class="text-danger amount-input-error">Please note that payments for under £100 may take longer to process.</p>
                                <p class="text-danger donations-are-subject-error">All donations are subject to compliance checks. Given the size of this donation, it is more likely to be selected for a random check. Please be aware that our Compliance Officer may be in touch with you to determine more information about this donation</p>
                                <p class="text-danger confirmation-amount">For your own safety please re-enter the amount you wish to donate </p>
                                <input type="text" name="confirmAmount" id="confirmAmount" class="form-control confirmation-amount input-text" placeholder="Please re-enter the amount you wish to donate">
                                <p class="text-danger confirmation-amount">In order to comply with money laundering  regulations,  this donation will also be eligible for random checks by our Compliance Officer. Please provide us a few sentences to outline the purpose of the donation to determine if we need to be in touch for more information. </p>
                                <input type="text" id="donationPurpose" name="donationPurpose" class="form-control confirmation-amount input-text" placeholder="Please enter the purpose of your donation">
                                <p class="text-danger confirmation-amount-error">This figure does not match the original amount.</p>
                            </div><!-- /box-make-donation -->

                            <?php /* <div class="box-make-donation visible-xs">
                              <h2 class="title-make-donation">NOTES TO CHARITY</h2>
                              <textarea cols="30" rows="10" class="textarea-make-dontation" placeholder="Add any notes you'd wish to pass on the charity."></textarea>
                              <p class="error error-text">Regrettably, we cannot make this payment since you may not use charitable funds to pay for a Raffle or tuition fees for your family. Please contact the office on 8731 8988 for further information” and reject the donation</p>
                              </div><!-- /box-make-donation --> */ ?>
                            <?php
                            $active = "";
                            $checked = "";
                            $disable = "disabled";

                            if ($fields['StandingOrderFrequency'] != "No" && $fields['StandingOrderFrequency'] != "") {
                                $active = "active";
                                $checked = "checked";
                                $disable = "";
                                $disableSO = "disabled";
                            }
                            ?>
                            <!-- AACDESIGN3 -->
                            <div class="box-make-donation standing-order-switch-container <?php echo $active; ?>">

                                <div class="half-make-donation">

                                    <h2 class="title-make-donation">STANDING ORDER</h2>

                                    <input type = "checkbox" <?php echo $disableSO ?> class = "standing-order-switch switch-on" id="my-checkbox" name="my-checkbox" <?php echo $checked; ?> >

                                </div><!-- /half-make-donation -->

                                <div class = "half-make-donation">
                                    <h2 class = "title-make-donation">PAYMENTS</h2>
                                    <?php
                                    /* $disable = "disabled";
                                      if ($checked == "checked") {
                                      $disable = "";
                                      } */
										//$disable ='';
                                    ?>
                                    <select id="StandingOrderType" name="fields[StandingOrderType]" class = "form-control selectpicker" <?php echo $disable; ?>>
                                        <option value="Fixed number of payments" >Fixed number of payments</option>
                                        <option value="Continuous payments" >Continuous payments</option>
                                    </select>
                                </div><!--/half-make-donation -->
                                <!-- start changes -->
                                <div class="half-make-donation">
                                </div>
                                <div class="half-make-donation">
                                    <h2 class="title-make-donation" id="lblNumberOfPayments">NUMBER OF PAYMENTS</h2>
                                    <input type="text" name="fields[NumberOfPayments]" id="txtNumberOfPayments" class="form-control input-text" placeholder="Enter number of payments" value="<?php echo $fields['NumberOfPayments']; ?>">
                                </div>
                                <!-- start changes -->

                                <div class="half-make-donation">

                                    <h2 class="title-make-donation">STARTING</h2>

                                    <select id="StandingOrderStartDate" name="fields[StandingOrderStartDate]" class = "form-control selectpicker" <?php echo $disable; ?>>
                                        <?php
                                        $options = array(date('Y-m-1') => date('M Y'));
                                        for ($i = 1; $i <= 3; $i++) {
                                            $t = strtotime("+{$i} months", strtotime(date('Y-m-1')));
                                            $options[date('Y-m-1', $t)] = date('M Y', $t);
                                        }
                                        foreach ($options as $op) {
                                            ?>
                                            <option value="1 <?php echo $op; ?>" <?php if (date('d M Y', $fields['StandingOrderStartDate']) == "1 " . $op) echo "selected"; ?>>1 <?php echo $op; ?></option>
                                            <option value="15 <?php echo $op; ?>" <?php if (date('d M Y', $fields['StandingOrderStartDate']) == "15 " . $op) echo "selected"; ?>>15 <?php echo $op; ?></option>
                                            <?php
                                        }
                                        reset($options);
                                        ?>

                                    </select>
                                    <input type="hidden" name="startdate" value="1 <?php echo current($options); ?>"/>
                                </div><!--/half-make-donation -->

                                <div class = "half-make-donation">

                                    <h2 class = "title-make-donation">INTERVAL </h2>

                                    <select id="StandingOrderFrequency" name="fields[StandingOrderFrequency]" class = "form-control selectpicker" <?php echo $disable; ?>>
                                        <option value="Every Month" <?php if ($row[0]->StandingOrderFrequency == "Every Month") echo "selected"; ?>>Every Month</option>
                                        <option value="Every 2 months" <?php if ($fields['StandingOrderFrequency'] == "Every 2 months") echo "selected"; ?>>Every 2 months</option>
                                        <option value="Every 3 months" <?php if ($fields['StandingOrderFrequency'] == "Every 3 months") echo "selected"; ?>>Every 3 months</option>
                                    </select>

                                </div><!--/half-make-donation -->

                            </div><!--/box-make-donation -->

                        </div><!--/col -->

                        <!-- Mobile -->
                        <div class="col-md-6 col-xs-12 padding-left">
                            <div class="box-make-donation "><!--hidden-xs-->
                                <h2 class="title-make-donation">NOTES TO CHARITY</h2>
                                <textarea id="ClientComments" name="fields[ClientComments]" cols = "30" rows = "10" class = "textarea-make-dontation" placeholder = "Add any notes you'd wish to pass on the charity."><?php echo $fields['ClientComments']; ?></textarea>
                                <p class="error error-text">Regrettably, we cannot make this payment since you may not use charitable funds to pay for a Raffle or tuition fees for your family. Please contact the office on 8731 8988 for further information” and reject the donation</p>
                            </div><!-- /box-make-donation -->
                            <div class="box-make-donation">
                                <h2 class="title-make-donation">NOTES TO AAC</h2>
                                <textarea id="OfficeComments" name="fields[OfficeComments]" cols = "30" rows = "10" class = "textarea-make-dontation" placeholder = "Add any notes you'd wish to pass on to AAC."><?php echo $fields['OfficeComments']; ?></textarea>
                                <p class="error error-text">Regrettably, we cannot make this payment since you may not use charitable funds to pay for a Raffle or tuition fees for your family. Please contact the office on 8731 8988 for further information” and reject the donation</p>
                            </div><!-- /box-make-donation -->
                            <div class="box-make-donation">
                                <h2 class="title-make-donation">MY NOTES</h2>
                                <textarea id="UserComments" name="fields[UserComments]" cols = "30" rows = "10" class = "textarea-make-dontation" placeholder = "Add any notes for your personal record keeping. These notes are searchable."><?php echo $fields['UserComments']; ?></textarea>
                                <p class="error error-text">Regrettably, we cannot make this payment since you may not use charitable funds to pay for a Raffle or tuition fees for your family. Please contact the office on 8731 8988 for further information” and reject the donation</p>
                            </div><!-- /box-make-donation -->
                        </div><!-- /col -->
                    </div><!-- /row -->
                </div><!-- /container -->
                <div id="cnfdonation" class="checkbox-box ">
                    <div class="container-fluid no-padding-desktop">
                        <div class="row">
                            <div class="col-md-6">
                                <a href = "#" class = "ckeckbox ConfirmTransfer" onclick="confirmTransfer()" name="Confirm">
                                    <span class="circle"></span>
                                    <span class="text">
                                        I confirm that this donation is for charitable purposes only, I will not benefit directly or indirectly by way of goods or services from the donation.
                                        <p class="text-danger">Please confirm to continue</p>
                                    </span>
                                </a>
                            </div><!-- /col -->
                            <div class="col-md-6 padding-left">
                                <a href = "#"  class = "make-dontation transition hidden-xs">Make Donation</a>
                            </div><!-- col -->
                        </div><!-- /row -->
                    </div><!-- /container -->
                </div><!-- /checkbox -->
                <a href="#" class="sticky-to-footer make-dontation make-dontation-mobile visible-xs">Make Donation</a>
            </div><!-- /mobile-content-make-dontation -->
            <?php
			if($somid) {
                $action = "edit-standing-order";
            } else if ($req_id != "") {
                $action = "edit";
            } else {
                $action = "save";
            }
            ?>
            <input type="hidden" name="doAction" value="<?php echo $action; ?>" />
            <input type="hidden" id="somid" name="somid" value="<?php echo $somid; ?>"/>
            <input type="hidden" id="request_id" name="request_id" value="<?php echo $req_id; ?>"/>
            <input type="hidden" id="hidden_allow" name="hidden_allow" value=""/>
            <input type="hidden" name="ConfirmTransfer" id="ConfirmTransfer"/>
<!--            <input type="hidden" name="fields[Request]" value="<?php echo $fields['Request']; ?>"/>-->
            <input type="hidden" id="StandingOrderEndDate" name="fields[StandingOrderEndDate]" value="" />
            <input type="hidden" id="clone" name="clone" value="<?php echo $_REQUEST['clone']; ?>" />

                        <input type="hidden" name="fields[RemoteCharityID]" value="<?php echo $fields['RemoteCharityID'] ?>" id="charityRemoteID" />
                        <input type="hidden" class="confirmation-box" name="confirm-transdetails" value="0" id="confirm-transdetails" />
                        <input type="hidden" class="confirmation-box" name="confirm-insufficiantbalance" value="0" id="confirm-insufficiantbalance" />
                        <input type="hidden" class="confirmation-box" name="confirm-bankcharges" value="0" id="confirm-bankcharges" />
                        <input type="hidden" class="confirmation-box" name="confirm-compliancemed" value="0" id="confirm-compliancemed" />
        </form>
    </main>	
<?php } ?>