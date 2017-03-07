<?php

require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'cls/charities.cls.php';
require_once 'cls/aac_requests.cls.php';
require_once 'cls/ui.cls.php';
require_once 'inc/funcs.inc.php';


	session_start();
	User::LoginCheck();

	AjaxCheck();

	$user = new User();
	$user = User::GetInstance();

$req_type = $_REQUEST['type'];
$sort_direction = $_REQUEST['sort']?$_REQUEST['sort']:'asc';
$sort_fieldname = $_REQUEST['fieldname']?$_REQUEST['fieldname']:'t.Voucher';

$sort = $_REQUEST;
$sort['sort'] = $sort_direction;
$sort['fieldname'] = $sort_fieldname;

$searchstr = $_REQUEST['searchstr'];

if($sort_fieldname=='t.Amount')$sort_fieldname='abs(t.Amount)';

$param = "";

$search = $_REQUEST;
unset($search['page']);
unset($search['ajax']);

foreach($search as $k=>$v) $search[$k] = trim($v);

$search['amount_donated_to'] = trim(str_replace('TO','',$search['amount_donated_to']));
$search['voucher_no_to'] = trim(str_replace('TO','',$search['voucher_no_to']));

//$search = array();


$td = new TransactionDetailList();
$transaction = $td->getTransactionDetailByAccountName($user->Reference);
foreach ($transaction as $tr) {
    $balance = $tr->Close_balance;
}
$rowBal = $balance;
if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

$transactionlist = new TransactionList();

$transactionlist->filters[] = 'UserName="' . intval($user->Username) . '" ';
$transactionlist->sortby = $sort_fieldname;
$transactionlist->sortorder = $sort_direction;
//$transactionlist->SetPage($page);

$book_voucher_no = $_REQUEST['book_voucher_no'];

$tl = $transactionlist->VoucherBookReport($book_voucher_no);

?>
<?php
$url = "PHPExcel_1.8.0_doc/export_excel.php?filename=csv";
$url1 = "PHPExcel_1.8.0_doc/export_excel.php?filename=xls";


//$search = $_REQUEST;



/**
$transactionlist->filters = array_merge($transactionlist->filters,$transactionlist->BuildSearch($searchF));
$param = '&'.http_build_query($searchF);
unset($search['type']);

$paramT = '&'.http_build_query($search);
**/

/**
if ($_REQUEST['sort'] && $_REQUEST['fieldname']) {
    $param .= '&&sort=' . $_REQUEST['sort'] . '&&fieldname=' . $_REQUEST['fieldname'];
}
**/

?>

<script type="text/javascript">
/*
function extractDomain(url) {
    var domain;
    //find & remove protocol (http, ftp, etc.) and get domain
    if (url.indexOf("://") > -1) {
        domain = url.split('/')[2];
    }
    else {
        domain = url.split('/')[0];
    }

    //find & remove port number
    domain = domain.split(':')[0];
    return domain;
}


  var reffer = "<?php echo $_SERVER['HTTP_REFERER'];?>";

  if(typeof reffer !== 'undefined'){
        var dir = extractDomain(reffer);
        var trimDir = dir.trim();
        //alert(dir);
        if(trimDir!=='devdb.exceedit.co.uk'){
          // alert("Not");
           window.location = "http://devdb.exceedit.co.uk/achisomoch-design/index.php?redir=1";
        } else{
            //alert("Yes");
        }
    }
*/
</script>

<script type="text/javascript">
    jQuery(document).ready(function () {

		$('.autocomplete-transaction-charities').autocomplete({
			source: 'remote.php?m=getTransactionCharityList',
		    messages: {
		        noResults: '',
		        results: function() {}
		    },
            appendTo: ".autocomplete-search-append",
			resultTextLocator:'label',
			select: function(event, ui){
				event.preventDefault();
				$('.autocomplete-transaction-charities').val(ui.item.name);

			}
		});

        $('.autocomplete-charities-mobile').autocomplete({
            source: 'remote.php?m=getCharityList',
            messages: {
                noResults: '',
                results: function() {}
            },
            appendTo: ".autocomplete-search-append-mobile",
            resultTextLocator:'label',
            select: function(event, ui){
                event.preventDefault();
                $('.autocomplete-charities-mobile').val(ui.item.name);

            }
        });


        jQuery("#txtCharityName").keyup(function () {
            //$(".results").css("visibility", "visible");
            var filter = jQuery(this).val().toLowerCase();
            jQuery(".results li").each(function () {
                var x = jQuery(this).text().toLowerCase();
                if (x.indexOf(filter) != -1) {
                    jQuery(this).hide();
                } else {
                    jQuery(this).hide();
                }
            });
        });
        jQuery(".results li a").click(function () {
            jQuery("#txtCharityName").attr('value', jQuery(this).text());
        });
        $('#txtCharityName').focus(function (event) {
            event.preventDefault( );
            //$(this).parent().parent().addClass('active');
        });
        $('.search .input').focus(function () {
            $(this).attr('placeholder', 'Type your search');
            //$(".results").css("visibility", "visible");
        });

    });
    function clearOthers(current_element) {
//disabled this as its causing problems and shouldnt be needed
return;
        if ($('#chkTransactionId').parent().hasClass('active') === false && $('#chkTransactionId') !== $(current_element)) {
            $('#txtTransactionId').val('');
        }

        if ($('#chkCharityName').parent().hasClass('active') === false && $('#chkCharityName') != $(current_element)) {
            $('#txtCharityName').val('');
        }
        if ($('#chkAmount').parent().hasClass('active') === false && $('#chkAmount') != $(current_element)) {
            $('#txtAmount').val('');
        }
        if ($('#chkNotes').parent().hasClass('active') === false && $('#chkNotes') != $(current_element)) {
            $('#txtNotes').val('');
        }
        if ($('#chkVoucherNumber').parent().hasClass('active') === false && $('#chkVoucherNumber') != $(current_element)) {
            $('#txtVoucherNumber').val('');
        }
        if ($('#chkBookVoucherNumber').parent().hasClass('active') === false && $('#chkBookVoucherNumber') != $(current_element)) {
            $('#txtBookVoucherNumber').val('');
        }
        if ($('#chkType').parent().hasClass('active') === false && $('#chkType') != $(current_element)) {
            $('#txtType').val('');
        }
    }

    $('#chkTransactionId').click(function (event) {
        event.preventDefault( );

        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers(this);
    });
    $('#chkCharityName').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers(this);
    });
    $('#chkAmount').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers(this);
    });
    $('#chkNotes').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers(this);
    });
    $('#chkVoucherNumber').click(function (event) {
        event.preventDefault();
        if ($('#chkVoucherNumber').parent().hasClass('active')) {
            $('#chkVoucherNumber').parent().removeClass('active');
        } else {
            $('#chkVoucherNumber').parent().addClass('active');
        }
        clearOthers(this);
    });
    $('#chkBookVoucherNumber').click(function (event) {
        event.preventDefault();
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers(this);
    });
    $('#chkType').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers(this);
    });

		if($('.sort-transactions .active').length) {
			var active = $('.sort-transactions .active');
 
			$('.navigator-transactions-sortby .text').text(active.text());
			$('.navigator-transactions-sortby .reset-sort').show();
		}

		if($('.navigator-transactions-li .dropdown-dates .selected').length) {
			var active = $('.navigator-transactions-li .dropdown-dates .selected').first();
// alert($('.dropdown-dates .selected').length);
			$('.dates_text_selected').text(active.text());
		}

			

</script>
<main class="main-transactions content-desktop report-voucher-book" >
    <div class="header-fixed visible-xs">
        <header class="header ">
            <div class="container ">
                <div class="row">
                    <div class="header-mobile-transactions">
                        <div class="col-xs-3"> <a href="dashboard.php" class="go-back"> <i class="fa fa-angle-left" aria-hidden="true"></i> </a> </div>
                        <!-- /col -->
                        <div class="col-xs-6">
                            <h2 class="title">Voucher Book Report</h2>
                        </div>
                        <!-- /col -->
                        <div class="col-xs-3"> <a href="#" class="nav-mobile nav-icon4 visible-xs "> <span></span> <span></span> <span></span> </a> </div>
                        <!-- /col -->
                    </div>
                    <!-- /header-mobile-transactions -->
                    <div class="col-xs-12 header-mobile-transactions">
     
                    </div>
                    <!-- /header-mobile-transactions -->
                    <div class="clear"></div>
                </div>
                <!-- /row  -->
            </div>
            <!-- /container  -->
        </header>
    </div>
    <!-- /header-fixed -->
    <div id="transactions-navigation-desktop" class="hidden-xs transactions-navigation-desktop">
        <div class="row">
            <div class="col-md-12">
                    <a href="transactions.php" class="history-back ">&lt; Back</a>
            </div>
            <div class="col-md-8">
                <h2 class="title-transactions-desktop">Voucher Book Report</h2>
                <!-- AACDESIGN -->					
            </div>
            <!-- / col 6 -->
            <!--- AACDESIGN4 -->
            <div class="export-file">

                 <?php
                    $url = "PHPExcel_1.8.0_doc/export_excel_reports_voucher_book.php?filename=csv";
                    $url1 = "PHPExcel_1.8.0_doc/export_excel_reports_voucher_book.php?filename=xlsx";

                        if ($_REQUEST['book_voucher_no']) {
                            $param = "&book_voucher_no=" . $_REQUEST['book_voucher_no'];
                        }
           
                  ?>

                    EXPORT DATA <span class="caret"></span>
                    <ul class="transition">
                        <li><a href="<?php echo $url . $param; ?>" id="export_csv" class="expert-csv-file transition">CSV FILE</a></li>
                        <li> <a href="<?php echo $url1 . $param; ?>" id="export_xls" class="expert-xls-file transition"> XLS FILE</a></li>
                    </ul>
                </div>

            <!-- / col 6 -->
        </div>
        <!-- / row -->
    </div>
    <!-- /transactions-navigation-desktop -->
    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-xs-12">
            <?php if (!$book_voucher_no || count($tl) < 1): ?>
            
                <p class="inst-msg">Please enter a voucher number in the box below to view the status of each voucher in its book</p>

            <?php endif; ?>
                <!-- AACDESING -->

                <form id="reports-voucher-book" >
                    <div class="container-input-quick-search">
                         <input class="form-control quick-search-form-control" placeholder="Enter voucher number" type="tel" name="book_voucher_no" value="<?php echo $book_voucher_no ?>" />
                         <?php if($searchstr && $dontShow) { ?>
                         <a href="transactions.php?type=<?php echo $_REQUEST['type'] ?>" class="ajaxlink">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                        <?php } ?>
                    </div>
                    <a href="javascript:void(0)" class="transition quick-button report-button" id="reportsVoucherBook" >SEARCH</a>

                    <input type="hidden" name="type" value="<?php echo $req_type ?>" />
                    <input type='hidden' name='startdate' id='startd' value="<?php echo $search['startdate'] ?>">
                    <input type='hidden' name='enddate' id='endd' value="<?php echo $search['enddate'] ?>">
                    <input type='hidden' name='dateType' id='dateType' value="<?php echo $search['dateType'] ?>">
                </form>
                <!-- /box-account-header -->

            </div>
            <!-- / col 12 -->
			<form id="transaction-search">
            <!-- AACDESIGN3 -->
            <div class="dropdown-search modal-search hidden-sm hidden-xs">
                <div class="col-md-12">
                    <h2 class="title-search">Search Transactions</h2>
                    <a href="javascript:void(0);" class="arrow-dropdown-search btn-dropdown-search"> <i class="fa fa-angle-up" aria-hidden="true"></i> </a>
                    <div class="form-modal-search">
                        <div class="form-group">
                            <label for="" class="label">TRANSACTION ID</label>
                            <div class="row-input <?php echo $_REQUEST['transaction_id']?'active':'' ?>"> 
                                <a href="javascript:void(0);" id="chkTransactionId" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>

                                <div class="mid-size container-input-search">

                                    <input type="tel" id="txtTransactionId" class="input input-search" placeholder="For a specific transaction." name="transaction_id" value="<?php echo $search['transaction_id'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>

                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">CHARITY NAME</label>
                            <span class="autocomplete-search-append"></span>
                            <div class="row-input <?php echo $_REQUEST['charity_name']?'active':'' ?>"> <a href="javascript:void(0);" id="chkCharityName" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                                
                                <div class="mid-size container-input-search">

                                    <input type="text" class="input autocomplete-transaction-charities input-search" id="txtCharityName" placeholder="Please enter the name of the charity" name="charity_name" value="<?php echo $search['charity_name'] ?>" />
                                    
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>

                                </div>
                            <?php /**
                            <div class="row-input <?php echo $_REQUEST['charity_name']?'active':'' ?>"> <a href="javascript:void(0);" id="chkCharityName" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                            	<input type="text" class="input autocomplete-charities" id="txtCharityName" placeholder="Please select a Beneficiary" name="charity_name" value="<?php echo $search['charity_name'] ?>" />
								
                                <div class="search" id="search">
                                    <span class="input-beneficiary caret" style="cursor:pointer;"></span>
                                    <input class="input input-beneficiary" type="text" id="txtCharityName" name="charity_name" placeholder="Please select a Beneficiary" autocomplete="false" value="<?php echo $search['charity_name'] ?>" />
                                    <ul class="results">
                                        <?php
                                        $cl = new CharityList();
                                        $charities = $cl->ListItems();
                                        if (count($charities)) {
                                            foreach ($charities as $c) {
                                                ?>
                                                <li class="charity"><a href="#"><span><?php echo $c->Name; ?></span><br/></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            
                            **/ ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">AMOUNT</label>
                            <div class="row-input <?php echo $_REQUEST['amount_donated_from'] || $_REQUEST['amount_donated_to']?'active':'' ?>"> <a href="javascript:void(0);" id="chkAmount" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                                
                                <div class="mid-size container-input-search container-input-search-min"
                                >
                                    <input type="tel" class=" input input-search" id="txtAmount" placeholder="Number" name='amount_donated_from' value="<?php echo $search['amount_donated_from'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="mid-size container-to-amount">
                                    <!-- AACDESIGN3 -->
                                    <input type="tel" class="input input-to-amount empty-state-input" id="txtAmount" placeholder="TO" name='amount_donated_to' value="<?php echo $search['amount_donated_to'] ?>">

                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">PERSONAL NOTES</label>
                            <div class="row-input <?php echo $_REQUEST['personal_note']?'active':'' ?>"> <a href="javascript:void(0);" id="chkNotes" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                                
                                <div class="mid-size container-input-search">
                                    <input type="text" class="input input-search" id="txtNotes" placeholder="Search your personal notes" name='personal_note' value="<?php echo $search['personal_note'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">VOUCHER NUMBER/S</label>
                            <div class="row-input <?php echo $_REQUEST['voucher_no_from'] || $_REQUEST['voucher_no_to']?'active':'' ?>"> <a href="javascript:void(0);" id="chkVoucherNumber" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                                
                                <div class="mid-size container-input-search container-input-search-min">
                                    <input type="tel" class="input input-search" id="txtVoucherNumber" placeholder="Number" name='voucher_no_from' value="<?php echo $search['voucher_no_from'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="mid-size container-to-amount">
                                    <!-- AACDESIGN3 -->
                                    <input type="tel" class=" input input-to-amount empty-state-input" id="txtVoucherNumber" placeholder="TO" name='voucher_no_to' value="<?php echo $search['voucher_no_to'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">DISPLAY VOUCHER BOOK</label>

                            <div class="row-input <?php echo $_REQUEST['book_voucher_no']?'active':'' ?>"> <a href="javascript:void(0);" id="chkBookVoucherNumber" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>

                                <div class="mid-size container-input-search">

                                    <input type="tel" class="input input-search" id="txtBookVoucherNumber" placeholder="Enter a voucher number" name='book_voucher_no' value="<?php echo $search['book_voucher_no'] ?>">
                                     <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">TRANSACTION TYPE</label>
                            <div class="row-input <?php echo $_REQUEST['transaction_type']?'active':'' ?>"> <a href="javascript:void(0);" id="chkType" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                                <!--
<input type="text" class="input" id="txtType" placeholder="Select the type of transactions " name='transaction_type'>
                                -->
                                <select id="txtType" class="input" name='transaction_type'>
									<option value="">Select...</option>
                                    <?php
                                    $sql = 'SELECT distinct cd_code, description FROM  transaction_index';
                                    $res = mysql_query($sql);
                                    while ($r = mysql_fetch_assoc($res)) {
                                        echo "<option value=\"{$r['cd_code']}\" ".($r['cd_code']==$search['transaction_type']?' selected ':'').">{$r['description']}</option>";
                                    }
                                    ?>	
                                </select>
                            </div>
                        </div>
                        <a href="javascript:void(0);" id='searchTransactions' class="btn-search search-desktop page transition transaction_page">Search Transactions</a>
                    </div>
                </div>
                <!-- /col -->
            </div>
				<input type="hidden" name="type" value="<?php echo $req_type ?>" />
                        <input type='hidden' name='startdate' id='startd' value="<?php echo $search['startdate'] ?>">
                        <input type='hidden' name='enddate' id='endd' value="<?php echo $search['enddate'] ?>">
                        <input type='hidden' name='dateType' id='dateType' value="<?php echo $search['dateType'] ?>">

			</form>
            <!-- /dropdown-search -->
        </div>
        <!-- / row -->
    </div>
    <!-- / top center content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="container-table ajax-transaction">
				<?php
				if(basename($_SERVER['PHP_SELF']) =='transactions-all.php') {
					die('call direct error');
				}
				?>
				<script>
				    function cancelStandingOrder(id)
				    {
				        BootstrapDialog.show({
				            message: 'Are you sure you want to cancel this standing order?',
				            buttons: [{
				                    label: 'Confirm',
				                    cssClass: 'btn-primary',
				                    action: function (dialogItself) {
				                        cancelOrder(id);
				                        dialogItself.close();
				                    }
				                }, {
				                    label: 'Cancel',
				                    action: function (dialogItself) {
				                        dialogItself.close();
				                    }
				                }]
				        });
				    }
				</script>
				<?php
				
				//$tl = $transactionlist->ListItems();
				
				//echo $transactionlist->lastSQL;
				
				if (!$book_voucher_no) {
				    ?>
				    
				    <?php
				} else  if (count($tl) < 1) {
				    ?>
				    <div class="container-fluid">
				        <div class="row">
				            <div class="col-xs-12">
				                <div class="empty-state">
				                    <p>Sorry, there are no results to display.</p>
	
				                    <a href="" class="">Get in touch with us</a>
				                </div>
				            </div>
				        </div>
				    </div>
				    <?php
				} else {
				    ?>

                    <script>
                        $('#reports-voucher-book').css('margin-left', '0');
                    </script>
				    <table class="table-transactions table table-condensed">
				        <thead class="hidden-xs "> 
				            <tr>
				                <th>DATE</th>
				                <!-- AACDESIGN3 -->
				                <th class="text-left">DESCRIPTION</th>
				                <th>AMOUNT</th>
<!--				                <th class="hidden-xs">COMMENTS</th>-->
				                <!--<th class="hidden-xs">TYPE</th>-->
				                <th class="hidden-xs">ACTION</th>
				            </tr>
				        </thead>						
				        <tbody>
				            <?php
				            if ($tl) {
				
				                foreach ($tl as $t) {
				                    $data = "";
				                    $status = "";
				
				                    if ($t->CDNo == "PEN") {
				                        //$status = "Currently being processed";
				                        $status = " Pending";
				                        $type = 'PENDING';
				                    }
				
				                    $balanceAmt = $rowBal;
				                    if (in_array($t->CDNo, array("VO", "PEN", "NV"))) {
				                        $modal_name = "#modal-voucher";
				                    } else if ($t->CDNo == "SO") {
				                        $modal_name = "#modal-standing-order-donation";
				                    } else if ($t->CDNo == "Cd" || $t->CDNo == "Ch") {
				                        $modal_name = "#modal-company-donation";
				                    } else {
				                        $modal_name = "";
				                    }
				
				                    $type = $t->TransactionDescription;
				
				                    $data .= $t->id . "||";
				                    $data .= $t->Name . "||";
				                    $data .= date('j-n-Y', strtotime($t->DateTime)) . "||";
				                    $data .= showBalance(abs($t->Amount)) . "||";
				                    $data .= $t->Voucher . "||";
				                    $data .= $t->StandingOrderType . ' ' . $t->NumberOfPayments . "||";
				                    $data .= $t->ClientComments . "||";
				                    $data .= $t->OfficeComments . "||";
				                    $data .= $t->CharityNumber . "||";
				
				                    if ($t->Voucher && substr($t->Voucher, 0, 1) == '9') {
				                        //$status = 'online request';
										$type = 'Online Donation';
				                    }
				
									$voucher = $t->Voucher?" <span>$t->Voucher</span>":'';
									
									$data = $t->id;
									$modal_name = $t->id?"#modal-voucher":'';
				
				                    //if ($i >= ($k - 10) && $i < $k) {
				                        ?>
				                        <tr class="<?php echo getBalanceColor(number_format($t->Amount, 2)); ?> transaction_all-row" data-id="<?php echo $data; ?>" data-type="TR">
				                            <?php /* <tr class="<?php echo $balance_color; ?> modal-show transaction_all-row" data-toggle="modal" data-target="<?php echo $modal_name; ?>" data-id="<?php echo $data; ?>" data-type="<?php echo $rows1[$i]['cd_no']; ?>"> */ ?>
				                            <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
				                                <a href="javascript:void(0);">
				                                    <div class="date"><?php echo strtotime($t->DateTime)?date('j-n-y', strtotime($t->DateTime)):''; ?></div>
				                                </a>
				                            </td>
				                            <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
				                                <a href="javascript:void(0);">
				                                    <div class="desc-table">
				                                        <h2 class="title">
				                                            <?php
				                                            echo $t->FormatDescription();
				                                            ?>
				                                        </h2>
				                                        <h3 class="subtitle transaction-type-label"><?php echo $voucher; ?></h3>
				                                    </div><!-- /desc-table -->
				                                </a>
				                            </td>
				                            <!-- AACDESIGN3 -->
				                            <td class="modal-show amount-td" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
				                                <a href="javascript:void(0);">
				                                    <span class="balance-transition voucher-balance">
				                                        <?php echo $t->FormatAmount(); ?>
				                                        <i class="fa fa-caret-up" aria-hidden="true"></i>
				                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
				                                    </span>
				                                </a>
				                            </td>
<!--
				                            <td class="modal-show comments-td hidden-xs" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
				                                <a href="javascript:void(0);">
				                                        <?php /* echo showBalance($balanceAmt); */?>
				                                        <p><?php echo $t->client_comment ?></p>
				                                </a>
				                            </td>
-->
				
				                              <td class="action-edit hidden-xs">
				                              <?php
				                              //$rows1[$i]['cd_no'] = "SO";
				                              //$rows1[$i]['request_id'] = "8176";
				                              if ($t->CDNo == "SO" && $t->so_master_id > 0) {
				                              ?>
				                              <!--<a href="make-a-donation.php?id=<?php //echo $rows1[$i]['request_id']; ?>&clone=1" class="refresh-transactions btn-trannsaction-accion external-lkn"></a>-->
				                              <a href="make-a-donation.php?SOMID=<?php echo $t->so_master_id; ?>" class="edit-transactions btn-trannsaction-accion external-lkn" alt="Amend this standing order" title="Amend this standing order"></a>
				                              <a href="javascript:void(0);" class="delete-transactions btn-trannsaction-accion" data-id="<?php echo $id; ?>" onClick="cancelStandingOrder('<?php echo $t->so_master_id; ?>');" alt="Cancel this standing order" title="Cancel this standing order"></a>
				                              <?php
				                              } else {
					                              if ($t->RequestId && $t->RequestId > 0) {
						                              ?>
						                              <a href="make-a-donation.php?id=<?php echo $t->RequestId; ?>&clone=1" class="refresh-transactions btn-trannsaction-accion external-lkn" alt="Make this donation again" title="Make this donation again"></a>
						                              <?php
					                              } else if (in_array($t->CDNo, array("VO", "PEN", "NV"))) {
						                              ?>
						                              <a href="make-a-donation.php?charityId=<?php echo $t->CharityNumber; ?>&amount=<?php echo abs($t->Amount); ?>" class="refresh-transactions btn-trannsaction-accion external-lkn" alt="Make this donation again" title="Make this donation again"></a>
						                              <?php							
					                              }
				                              }
				                              ?>
				                              </td>
				                    <input type="hidden" name="vchnumber" class="vch-number" value="<?php echo $t->Voucher; ?>">
				                    </tr>
				                    <?php
				               // }
				                $i++;
				            }
				            //$cnt = $k - 1;
				        }
				        ?>
				        </tbody>
				        <input type="hidden" id="current_data" name="current_data" value="<?php print base64_encode(serialize($tl)); ?>">
				    </table>
				    <nav class="navigation-transactions " aria-label="Page navigation  "><!--hidden-xs-->
				        <ul class="pagination nav-transactions"><li>
				            <?php
				
							$pageNavOptions  = array(
								'NoItemsText'=>'',
								'MaxVisiblePageNums'=>5,
								'PrevPageText'=>'<i class="fa fa-angle-left" aria-hidden="true"></i>',
								'NextPageText'=>'<i class="fa fa-angle-right" aria-hidden="true"></i>',
								'FirstPageText'=>'<i class="fa fa-angle-left" aria-hidden="true"></i><i class="fa fa-angle-left" aria-hidden="true"></i>',
								'LastPageText'=>'<i class="fa fa-angle-right" aria-hidden="true"></i><i class="fa fa-angle-right" aria-hidden="true"></i>',
								'ShowAllText'=>'',
								'ShowAllAlign'=>'',
								'LeadingText'=>'',
								'SuffixText'=>'',
								'PageNumSeperator'=>'</li><li>',
								'UseJavascriptFunction'=>'',
							);
				
				
							echo UI::makePageNav('transactions.php',$page,$transactionlist->PageCount(),false,$_GET,$pageNavOptions);
							?>
				        </li></ul>
				    </nav><!-- /navigation-transactions -->
				    <?php
				}
				?>

                </div>
                <!-- /container-table -->
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container-fluid -->
</main>

<span class="transaction-refference"></span>
