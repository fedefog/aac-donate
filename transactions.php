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
	$user = new User();
	$user = User::GetInstance();

$req_type = $_REQUEST['type'];
$sort_direction = $_REQUEST['sort']?$_REQUEST['sort']:'desc';
$sort_fieldname = $_REQUEST['fieldname']?$_REQUEST['fieldname']:'DateTime';

$param = "";

$search = $_REQUEST;
foreach($search as $k=>$v) if(!is_array($v)) $search[$k] = mysql_real_escape_string($v);

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
$transactionlist->SetPage($page);


if ($req_type == "in") {
		$transactionlist->filters[] = ' Amount > 0';
		$param .= "&type={$_REQUEST['type']}";
} else if ($req_type == "out") {
		$transactionlist->filters[] = ' Amount < 0';
		$param .= "&type={$_REQUEST['type']}";
}

?>
<?php
$url = "PHPExcel_1.8.0_doc/export_excel.php?filename=csv";
$url1 = "PHPExcel_1.8.0_doc/export_excel.php?filename=xls";


//$search = $_REQUEST;

    if ($search['transaction_id']) {
		$transactionlist->filters[] = " `t`.`RequestId`='{$search['transaction_id']}' ";
		$param .= "&transaction_id={$_REQUEST['transaction_id']}";
    } 
	if ($search['charity_name']) {
		$transactionlist->filters[] = " `c`.`Name` LIKE '%{$search['charity_name']}%' ";
		$param .= "&charity_name={$_REQUEST['charity_name']}";
    } 
	if ($search['amount_donated_from']) {
		$neg = $search['amount_donated_from']*-1;
		$transactionlist->filters[] = " (`amount`>='{$search['amount_donated_from']}' OR `amount`='{$neg}' ) ";
		$param .= "&amount_donated_from={$_REQUEST['amount_donated_to']}";
    } 
	if ($search['amount_donated_to']) {
		$neg = $search['amount_donated_to']*-1;
		$transactionlist->filters[] = " (`amount`<='{$search['amount_donated_to']}' OR `amount`='{$neg}' ) ";
		$param .= "&amount_donated_to={$_REQUEST['amount_donated_to']}";
    } 
	if ($search['personal_note']) {
		$transactionlist->filters[] = " `client_comment` LIKE '%{$search['personal_note']}%' ";
		$param .= "&amount_donated={$_REQUEST['amount_donated']}";
    } 
	if ($search['voucher_no_from']) {
		$transactionlist->filters[] = " `voucher`>='{$search['voucher_no_from']}' ";
		$param .= "&voucher_no_from={$_REQUEST['voucher_no_from']}";
    } 
	if ($search['voucher_no_to']) {
		$transactionlist->filters[] = " `voucher`<='{$search['voucher_no_to']}' ";
		$param .= "&voucher_no_to={$_REQUEST['voucher_no_to']}";
    } 
	if ($search['book_voucher_no']) {
		$transactionlist->filters[] = $transactionlist->GetVoucherBookRangeFilter($search['book_voucher_no']);
		$param .= "&book_voucher_no={$_REQUEST['book_voucher_no']}";
    } 
	if ($search['transaction_type']) {
		$transactionlist->filters[] = " `CDNo`='{$search['transaction_type']}' ";
		$param .= "&transaction_type={$_REQUEST['transaction_type']}";
    }

	if ($search['startdate']) {
		//convert to db format
		$d = explode('-',$search['startdate']);
		$dbsearch['startdate'] = "{$d['2']}-{$d['1']}-{$d['0']}";
		$transactionlist->filters[] = " `DateTime`>='{$dbsearch['startdate']}' ";
	    $param .= '&startdate=' . $search['startdate'];
	}
	if ($search['enddate']) {
		$d = explode('-',$search['enddate']);
		$dbsearch['enddate'] = "{$d['2']}-{$d['1']}-{$d['0']}";

		$transactionlist->filters[] = " `DateTime`<='{$dbsearch['enddate']}' ";
	    $param .= '&enddate=' . $search['enddate'];
	}

function buildDates($key){
	global $search;

	$search2 = $search;

	if($key!='custom') {
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
	return $result;

}

$dates = array(
	'3months'=>buildDates('3 Months'),
	'6months'=>buildDates('6 Months'),
	'1year'=>buildDates('12 Months'),
	'3years'=>buildDates('36 Months'),
	'5years'=>buildDates('60 Months'),
	'custom'=>buildDates('custom'),
);

if(!$search['startdate']) {
	$defaultDate = reset($dates);

//var_dump($defaultDate);

	$d = explode('-',$defaultDate['startdate']);
	$defaultDate['startdate'] = "{$d['2']}-{$d['1']}-{$d['0']}";
	$d = explode('-',$defaultDate['enddate']);
	$defaultDate['enddate'] = "{$d['2']}-{$d['1']}-{$d['0']}";

	$transactionlist->filters[] = " `DateTime`>='{$defaultDate['startdate']}' ";
	$transactionlist->filters[] = " `DateTime`<='{$defaultDate['enddate']}' ";

}

/**
if ($_REQUEST['sort'] && $_REQUEST['fieldname']) {
    $param .= '&&sort=' . $_REQUEST['sort'] . '&&fieldname=' . $_REQUEST['fieldname'];
}
**/

?>

<script type="text/javascript">
    jQuery(document).ready(function () {

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
            // $(this).parent().parent().addClass('active');
        });
        $('.search .input').focus(function () {
            $(this).attr('placeholder', 'Type your search');
            //$(".results").css("visibility", "visible");
        });


    });
    function clearOthers(current_element) {

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

		if($('.dropdown-dates .selected').length) {
			var active = $('.dropdown-dates .selected');
 
			$('.dates_text_selected').text(active.text());
		}

			

</script>
<main class="main-transactions content-desktop" >
    <div class="header-fixed visible-xs">
        <header class="header ">
            <div class="container ">
                <div class="row">
                    <div class="header-mobile-transactions">
                        <div class="col-xs-3"> <a href="dashboard.php" class="go-back"> <i class="fa fa-angle-left" aria-hidden="true"></i> </a> </div>
                        <!-- /col -->
                        <div class="col-xs-6">
                            <h2 class="title">Transactions</h2>
                        </div>
                        <!-- /col -->
                        <div class="col-xs-3"> <a href="#" class="nav-mobile nav-icon4 visible-xs "> <span></span> <span></span> <span></span> </a> </div>
                        <!-- /col -->
                    </div>
                    <!-- /header-mobile-transactions -->
                    <div class="col-xs-12 header-mobile-transactions">
                        <ul class="nav-transactions transaction_page_mobile">
                            <li class="nav-transactions-li"> <a href="transactions.php" class="nav-transactions-lkn active">all</a> </li>
                            <li class="nav-transactions-li"> <a href="transactions.php?type=in" class="nav-transactions-lkn">in</a> </li>
                            <li class="nav-transactions-li"> <a href="transactions.php?type=out" class="nav-transactions-lkn">out</a> </li>
                        </ul>
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
            <div class="col-md-8">
                <h2 class="title-transactions-desktop">Transactions</h2>
                <!-- AACDESIGN -->
                    <a href="transactions-processing.php" class="btn-being-processed ajaxlink"><span class="number-notification"><?php echo AACRequestList::CountProcessing(); ?></span><span class="noti-string">being processed</span></a>
                    <a href="transactions-pending.php" class="btn-pendings ajaxlink"><span class="number-notification"><?php echo TransactionList::CountPending(); ?></span> <span class="noti-string">PENDING</span></a>
                    <!-- END AACDESIGN -->
                <ul class="nav-transactions transaction_page_desktop">
                    <li class="nav-transactions-li"> <a href="transactions.php" class="nav-transactions-lkn<?php echo $req_type?'':' active' ?>">all</a> </li>
                    <li class="nav-transactions-li"> <a href="transactions.php?type=in" class="nav-transactions-lkn<?php echo $req_type=='in'?' active':'' ?>">in</a>
                        <?php /* <a href="transactions-in.php" class="nav-transactions-lkn">in</a> */ ?>
                    </li>
                    <li class="nav-transactions-li"> <a href="transactions.php?type=out" class="nav-transactions-lkn<?php echo $req_type=='out'?' active':'' ?>">out</a>
                        <?php /* <a href="transactions-out.php" class="nav-transactions-lkn">out</a> */ ?>
                    </li>
                </ul>
            </div>
            <!-- / col 6 -->
            <div class="col-md-4 text-right">
                <?php
                $url = "PHPExcel_1.8.0_doc/export_excel.php?filename=csv";
                $url1 = "PHPExcel_1.8.0_doc/export_excel.php?filename=xls";

					if ($_REQUEST['fieldname']) {
                        $param = $param . "&fieldname=" . $_REQUEST['fieldname'];
                    }
					if ($_REQUEST['sort']) {
                        $param = $param . "&sort=" . $_REQUEST['sort'];
                    }



                ?>
                <a href="<?php echo $url . $param; ?>" id="export_csv" class="expert-csv-file">EXPORT DATA TO CSV FILE</a> 
                <a href="<?php echo $url1 . $param; ?>" id="export_xls" class="expert-xls-file">EXPORT DATA TO XLS FILE</a>
            </div>
            <!-- / col 6 -->
        </div>
        <!-- / row -->
    </div>
    <!-- /transactions-navigation-desktop -->
    <div class="container-fluid top-center-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- AACDESING -->

                <div class="visible-xs">

                    <a href="#" class="btn-being-processed-mobile"><span class="number-notification">2</span>Currently being processed</a>
                    <a href="#" class="btn-pendings-mobile"><span class="number-notification">4</span> PENDING</a>
                    
                </div>
                <!-- /box-account-header -->
                
                <ul class="navigator-transactions">
                    <li class="navigator-transactions-li"> <a href="transactions.php" class="navigator-transactions-lkn lkn-recent active page btn-active external-lkn">RECENT</a> </li>
                    <li class="navigator-transactions-li visible-xs"> <a href="javascript:void(0);" id="dates-bt-modal" class="navigator-transactions-lkn visible-xs">DATES</a>
                        <input type="text" id="config-date" class="form-control hidden-xs" placeholder="Select Date">
                        <a href='#' id="startDate"></a>
                        <i class="glyphicon glyphicon-calendar fa fa-calendar hidden-xs"></i> 
                    </li>
                    <li class="navigator-transactions-li hidden-xs"> 
                        <a href="javascript:void(0);" class="navigator-transactions-lkn lkn-sortby lkn-dates"> 
                            <i class="glyphicon glyphicon-calendar fa fa-calendar hidden-xs"></i>
                            <span class="dates_text_selected hidden-xs">PREVIOUS 3 MONTHS</span>                              
                            <i class="fa fa-long-arrow-up pull-right" aria-hidden="true"></i>
                        </a>
                        <div class="drop-down-sort dropdown-dates"> 
                            <div class="container-sortby">



                                <ul class="list-sortby">
                                    <li class="sortby-li"> <a href="<?php echo $dates['3months']['url'] ?>" class="date-lkn first-date-lkn page <?php echo $dates['3months']['dateType']==$search['dateType']?' selected ':'' ?>">PREVIOUS 3 MONTHS</a> </li>
                                    <li class="sortby-li"> <a href="<?php echo $dates['6months']['url'] ?>" class="date-lkn page <?php echo $dates['6months']['dateType']==$search['dateType']?' selected ':'' ?>">PREVIOUS 6 MONTHS</a> </li>
                                    <li class="sortby-li"> <a href="<?php echo $dates['1year']['url'] ?>" class="date-lkn page <?php echo $dates['1year']['dateType']==$search['dateType']?' selected ':'' ?>">PREVIOUS YEAR</a> </li>
                                    <li class="sortby-li"> <a href="<?php echo $dates['3years']['url'] ?>" class="date-lkn page <?php echo $dates['3years']['dateType']==$search['dateType']?' selected ':'' ?>">PREVIOUS 3 YEARS</a> </li>
                                    <li class="sortby-li"> <a href="<?php echo $dates['5years']['url'] ?>" class="date-lkn page <?php echo $dates['5years']['dateType']==$search['dateType']?' selected ':'' ?>">PREVIOUS 5 YEARS</a> </li>
                                    <li class="sortby-li"> 
                                        <a href="javascript:void(0);" class="date-lkn custom-range-lkn <?php echo $dates['custom']['dateType']==$search['dateType']?' selected ':'' ?>">
                                        CUSTOM DATE RANGE
                                        </a> 
                                        <div class="custom-range-container">
                                            <?php /*<input class="col-xs-12" type="text" name="datarange" value="10/24/1984" /> */ ?>
                                            <input class="col-xs-5" type="text" name="customstartdate" id="customstartdate" value="<?php echo $dates['custom']['startdate'] ?>" />
                                            <span class="col-xs-2">-</span>
                                            <input class="col-xs-5" type="text" name="customenddate" id="customenddate" value="<?php echo $dates['custom']['enddate'] ?>" />
											<a class="custom-date-go" href="#">go</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- /container-sortby -->
                        </div>
                        <!-- /drop-down-sort -->
                    </li>
                    <li class="navigator-transactions-li"> <a href="javascript:void(0);" class="navigator-transactions-lkn lkn-search visible-xs" data-toggle="modal" data-target="#modal-search" >SEARCH</a> </li>
                    <li class="navigator-transactions-li hidden-xs"> 
                        <a href="javascript:void(0);" class="navigator-transactions-lkn lkn-search  lkn-seach-desktop btn-dropdown-search"  >ADVANCED FILTERS
                        <i class="fa fa-long-arrow-up pull-right" aria-hidden="true"></i>
                        </a> 
                    </li>   

                    <li class="navigator-transactions-li navigator-transactions-sortby "> 
                        <a href="transactions.php" class="reset-sort hidden-xs">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:void(0);" class="navigator-transactions-lkn lkn-sortby"> 
                                <span class="text hidden-xs">SORT BY</span>  
                                <i class="fa fa-sort-amount-desc visible-xs" aria-hidden="true"></i>
                            </a>
                                <i class="fa fa-sort-amount-desc hidden-xs" aria-hidden="true"></i>
                        <div class="drop-down-sort"> 
                            <div class="container-sortby">
                    <!-- END AACDESING -->
                                <ul class="list-sortby  sort-transactions">
                                    <li class="sortby-li">
                                        <h2 class="title-sortby">SORT BY</h2>
                                    </li>
                                    <li class="sortby-li <?php echo $_REQUEST['fieldname']=='t.Datetime' && $_REQUEST['sort']==DESC?'active':'' ?>"> <a href="transactions.php?fieldname=t.Datetime&&sort=DESC" class="sortby-lkn page">Date
                                            (Recent - Furthest)</a> </li>
                                    <li class="sortby-li <?php echo $_REQUEST['fieldname']=='t.Datetime' && $_REQUEST['sort']==ASC?'active':'' ?>"> <a href="transactions.php?fieldname=t.Datetime&&sort=ASC" class="sortby-lkn page">Date
                                            (Furthest - Recent)</a> </li>
                                    <li class="sortby-li <?php echo $_REQUEST['fieldname']=='t.Amount' && $_REQUEST['sort']==DESC?'active':'' ?>"> <a href="transactions.php?fieldname=t.Amount&&sort=DESC" class="sortby-lkn page">Amount
                                            (High - Low)</a> </li>
                                    <li class="sortby-li <?php echo $_REQUEST['fieldname']=='t.Amount' && $_REQUEST['sort']==ASC?'active':'' ?>"> <a href="transactions.php?fieldname=t.Amount&&sort=ASC" class="sortby-lkn page">Amount
                                            (Low - High)</a> </li>
                                    <li class="sortby-li <?php echo $_REQUEST['fieldname']=='t.Description' && $_REQUEST['sort']==ASC?'active':'' ?>">
                                        <!--<a href="transactions.php?fieldname=name&&sort=SORT_ASC" class="sortby-lkn page">Charity Name (A - Z)</a>-->
                                        <a href="transactions.php?fieldname=t.Description&&sort=ASC" class="sortby-lkn page">Charity
                                            Name (A - Z)</a> </li>
                                    <li class="sortby-li <?php echo $_REQUEST['fieldname']=='t.Description' && $_REQUEST['sort']==DESC?'active':'' ?>">
                                        <!--<a href="transactions.php?fieldname=name&&sort=SORT_DESC" class="sortby-lkn page">Charity Name (Z - A)</a>-->
                                        <a href="transactions.php?fieldname=t.Description&&sort=DESC" class="sortby-lkn page">Charity
                                            Name (Z - A)</a> </li>
                                </ul>
                            </div>
                            <!-- /container-sortby -->
                        </div>
                        <!-- /drop-down-sort -->
                    </li>
                </ul>
                <div class="filters-selected hidden-xs">
					<?php
					function showFilter($key){
						global $search;

						$labels = array(
							'transaction_id'=>'NO',
							'charity_name'=>'CHARITY',
							'amount_donated'=>'AMOUNT',
							'personal_note'=>'NOTE',
							'voucher_no'=>'VOUCHER',
							'voucher_book'=>'BOOK',
							'transaction_type'=>'TYPE',
							'dates'=>'DATE',
						);

						$value = '';
						$search2 = $search;

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
						} else {
							$value = $search[$key];
							unset($search2[$key]);
						}

						if(!$value) return;
	
						$label = $labels[$key];
						$params = http_build_query($search2);
					
						?>
	                    <span class="filter-selected"><a href="transactions.php?<?php echo $params ?>">x</a><?php echo "{$label}:$value" ?></span>
						<?php	

					}
					foreach($search as $k=>$v) if(!$v) unset($search[$k]);
					if(count($search)) {
						showFilter('transaction_id');
						showFilter('charity_name');
						showFilter('amount_donated');
						showFilter('personal_note');
						showFilter('voucher_no');
						showFilter('voucher_book');
						showFilter('transaction_type');
						showFilter('dates');
						?>
	                    <span class="clear-all-filters"><a href="transactions.php">x</a>CLEAR ALL</span>
						<?php
					}
					?>
                </div>
            </div>
            <!-- / col 12 -->
			<form id="transaction-search">
            <div class="dropdown-search modal-search hidden-xs">
                <div class="col-md-12">
                    <h2 class="title-search">Search Transactions</h2>
                    <a href="javascript:void(0);" class="arrow-dropdown-search btn-dropdown-search"> <i class="fa fa-angle-up" aria-hidden="true"></i> </a>
                    <div class="form-modal-search">
                        <div class="form-group">
                            <label for="" class="label">TRANSACTION ID</label>
                            <div class="row-input <?php echo $_REQUEST['transaction_id']?'active':'' ?>"> 
                                <a href="javascript:void(0);" id="chkTransactionId" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>

                                <div class="mid-size container-input-search">

                                    <input type="text" id="txtTransactionId" class="input input-search" placeholder="For a specific transaction." name="transaction_id" value="<?php echo $search['transaction_id'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>

                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">CHARITY NAME</label>
                            <div class="row-input <?php echo $_REQUEST['charity_name']?'active':'' ?>"> <a href="javascript:void(0);" id="chkCharityName" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
                                
                                <div class="mid-size container-input-search">

                                    <input type="text" class="input autocomplete-charities input-search" id="txtCharityName" placeholder="Please enter the name of the charity" name="charity_name" value="<?php echo $search['charity_name'] ?>" />
                                    
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
                                    <input type="text" class=" input input-search" id="txtAmount" placeholder="Amount number" name='amount_donated_from' value="<?php echo $search['amount_donated_from'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>

                                <div class="mid-size container-to-amount">
                                        
                                    <input type="text" class="input input-to-amount" id="txtAmount" placeholder="TO" name='amount_donated_to' value="<?php echo $search['amount_donated_to'] ?>">

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
                                    <input type="text" class="input input-search" id="txtVoucherNumber" placeholder="Voucher Number" name='voucher_no_from' value="<?php echo $search['voucher_no_from'] ?>">
                                    <a href="#" class="reset-input">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="mid-size container-to-amount">

                                    <input type="text" class=" input input-to-amount" id="txtVoucherNumber" placeholder="TO" name='voucher_no_to' value="<?php echo $search['voucher_no_to'] ?>">
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

                                    <input type="text" class="input input-search" id="txtBookVoucherNumber" placeholder="Enter a voucher number" name='book_voucher_no' value="<?php echo $search['book_voucher_no'] ?>">
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
                                        echo "<option value=\"{$r['cd_code']}\" ".($r['cd_code']==$search['transaction_type']?' selected ':'').">{$r['description']} ({$r['cd_code']})</option>";
                                    }
                                    ?>	
                                </select>
                            </div>
                        </div>
                        <a href="javascript:void(0);" id='searchTransactions' class="btn-search page transition transaction_page">Search Transactions</a>
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
                    <?php include 'transactions-all.php' ?>
                </div>
                <!-- /container-table -->
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container-fluid -->
</main>
<div class="modal-search modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-modal-search">
                    <?php include "transaction-search-html.php"; ?>
                    <?php /* <a href="transactions.php" class="btn-search page transaction_page">Search Transactions</a> </div> */ ?>
                    <a href="javascript:void(0);" id='searchTransactions' class="btn-search page transition transaction_page">Search Transactions</a>
                </div>
                <!-- /modal-body -->
            </div>
            <!-- /modal-content -->
        </div>
        <!-- /modal-dialog -->
    </div>
    <!-- /modal-search -->
    <div class="modal-backdrop fade sort-back"></div>
