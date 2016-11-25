<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'cls/vouchers.cls.php';
require_once 'cls/charities.cls.php';
require_once 'cls/aac_requests.cls.php';
require_once 'inc/funcs.inc.php';

session_start();

User::LoginCheck();

$user = new User();
$user = User::GetInstance();

$charity_id = $_REQUEST['charityId'];

/* $qry = "";
  $qry .= "SELECT Name FROM charities ";
  $qry .= "WHERE remote_charity_id = " . $charity_id;
  $result = mysql_query($qry);
  $row = mysql_fetch_row($result);
  $charity_name = $row[0]; */
$transactionlist = new TransactionList();
$charity_row = $transactionlist->getCharityList($charity_id);
$charity_name = $charity_row[0]->Name;

if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$url = "PHPExcel_1.8.0_doc/export_excel.php?filename=csv";
$url1 = "PHPExcel_1.8.0_doc/export_excel.php?filename=xls";
$param = "&charity_name=" . $charity_name;

$transactionlist = new TransactionList();
$search_array = array();
$search = $charity_id;
$field = 't.CharityNumber';
$search_array[] = array($field, '=', $search);
$tl = $transactionlist->getTransactionListSearch($user->id, $search_array);
/* for ($i = 0; $i < count($tl); $i++) {
  $rows1[$i]['id'] = $tl[$i]->id;
  $rows1[$i]['user_id'] = $tl[$i]->Username;
  $rows1[$i]['voucher_old'] = $tl[$i]->Voucher_old;
  $rows1[$i]['voucher'] = $tl[$i]->Voucher;
  $rows1[$i]['datetime'] = date('j-n-y', strtotime($tl[$i]->DateTime));
  $rows1[$i]['amount'] = $tl[$i]->Amount;
  $rows1[$i]['recipient_name'] = $tl[$i]->RecipientName;
  $rows1[$i]['charity_number'] = $tl[$i]->CharityNumber;
  $rows1[$i]['name'] = $tl[$i]->Name;
  $rows1[$i]['cd_no'] = $tl[$i]->CDNo;
  $rows1[$i]['request_id'] = $tl[$i]->RequestId;
  $rows1[$i]['request_datetime'] = $tl[$i]->RequestDateTime;
  $rows1[$i]['client_comments'] = $tl[$i]->ClientComments;
  $rows1[$i]['office_comments'] = $tl[$i]->OfficeComments;
  $rows1[$i]['standingorder_enddate'] = $tl[$i]->StandingOrderEndDate;
  $rows1[$i]['payment_number'] = $tl[$i]->PaymentNumber;
  $rows1[$i]['description'] = $tl[$i]->description;
  $rows1[$i]['Description'] = $tl[$i]->Description;
  } */
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#export_csv').attr("href", "<?php echo $url . $param; ?>");
        jQuery('#export_xls').attr("href", "<?php echo $url1 . $param; ?>");

        jQuery(document).on('click', '.transaction_history-row', function () {
            var modal_data = jQuery(this).data('id');
            var modal_type = jQuery(this).data('type');
            var row_arr = modal_data.split('||');
            if (modal_type == "VO" || modal_type == "NV" || modal_type == "PEN") {
                jQuery('#vo_mdl_beneficiary').html('');
                jQuery('#vo_mdl_beneficiary').html(row_arr[1]);
                jQuery('#vo_mdl_dnt_amt').html('');
                jQuery('#vo_mdl_dnt_amt').html(row_arr[3]);
                jQuery('#vo_mdl_dt_prcd').html('');
                jQuery('#vo_mdl_dt_prcd').html(row_arr[2]);
                jQuery('#vo_mdl_vch_num').html('');
                jQuery('#vo_mdl_vch_num').html(row_arr[4]);
                jQuery("#lnk_vch_donate_again").attr('href', 'make-a-donation.php?charity_id=' + row_arr[8]);
            } else if (modal_type == "SO") {
                jQuery('#modal_beneficiary').html('');
                jQuery('#modal_beneficiary').html(row_arr[1]);
                jQuery('#modal_date_paid').html('');
                jQuery('#modal_date_paid').html(row_arr[2]);
                jQuery('#modal_amount').html('');
                jQuery('#modal_amount').html(row_arr[3]);
                jQuery('#modal_payments_number').html('');
                jQuery('#modal_payments_number').html(row_arr[5]);
                jQuery('#modal_notes_aac').html('');
                if (row_arr[6] == "") {
                    jQuery('#modal_notes_aac').html("No Notes have been added");
                } else {
                    jQuery('#modal_notes_aac').html(row_arr[6]);
                }
                jQuery('#modal_charity_notes').html('');
                if (row_arr[7] == "") {
                    jQuery('#modal_charity_notes').html("No Notes have been added");
                } else {
                    jQuery('#modal_charity_notes').html(row_arr[7]);
                }
                jQuery("#lnk_view_all").attr('href', 'standing-orders.php?charity_id=' + row_arr[8]);
            } else if (modal_type == "Cd" || modal_type == "Ch") {
                jQuery('#mdl_comp_name').html('');
                jQuery('#mdl_comp_name').html(row_arr[1]);
                jQuery('#mdl_amount').html('');
                jQuery('#mdl_amount').html(row_arr[3]);
                jQuery('#mdl_date').html('');
                jQuery('#mdl_date').html(row_arr[2]);
                jQuery("#lnk_donate_again").attr('href', 'make-a-donation.php?charity_id=' + row_arr[8]);
            }
        });
    });
</script>
<main class="main-transactions main-transactions-history content-desktop" >
    <div class="header-fixed visible-xs">
        <header class="header ">
            <div class="container ">
                <div class="row">
                    <div class="header-mobile-transactions">
                        <div class="col-xs-3">
                            <a href="dashboard.php" class="go-back">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                            </a>
                        </div><!-- /col -->
                        <div class="col-xs-6">
                            <h2 class="title">Transactions</h2>
                        </div><!-- /col -->	
                        <div class="col-xs-3">
                            <a href="#" class="nav-mobile nav-icon4 visible-xs ">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div><!-- /col -->	
                    </div><!-- /header-mobile-transactions -->
                    <div class="title-transactions-history">
                        <h3 class="title-transactions">DONATIONS TO <?php echo $charity_name; ?></h3>
                    </div><!-- /title-transactions-result -->
                    <div class="clear"></div>
                </div><!-- /row  -->	
            </div><!-- /container  -->
        </header>
    </div><!-- /header-fixed -->
    <div id="transactions-navigation-desktop" class="hidden-xs transactions-navigation-desktop">
        <div class="row">
            <div class="col-md-6">
                <div class="title-standing-orders-transactions">
                    <h3 class="title-transactions">DONATIONS TO <?php echo $charity_name; ?></h3>
					<a href="./" class="history-back">&lt; back</a>
                </div><!-- /title-transactions-result -->
            </div><!-- / col 6 -->
            <div class="col-md-6 text-right ">
                <a href="#" id="export_csv" class="expert-csv-file">EXPORT DATA TO CSV FILE</a> 
                <a href="#" id="export_xls" class="expert-xls-file">EXPORT DATA TO XLS FILE</a>
            </div><!-- / col 6 -->
        </div><!-- / row -->
    </div><!-- /transactions-navigation-desktop -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <?php
                if (count($tl) < 1) {
                    ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="empty-state">
                                    <p>Sorry, there are no results to display.</p>
                                    <ul>
                                        <li>Check your spelling, dates, or figures</li>
                                        <li>Try a different search tool</li>
                                    </ul>
                                    <span>OR</span>
                                    <a href="" class="empty-action">Get in touch with us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="container-table">
                        <table class="table-transactions table table-condensed">
                            <thead class="hidden-xs "> 
                                <tr>
                                    <th>DATE</th>
                                    <!--<th class="desktop-align-left">ID</th>-->
                                    <th>CHARITY</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($tl) {
                                    //$cnt = 0;
                                    $k = $page * 10;
                                    $i = ($page - 1) * 10;
                                    $i = 0;
                                    foreach ($tl as $t) {
                                        $data = "";
                                        $status = "";
                                        $type = $t->description;
                                        if ($t->CDNo == "PEN") {
                                            //$status = "Currently being processed";
                                            $status = "Pending";
                                            $type = 'PENDING';
                                        }

                                        if (in_array($t->CDNo, array("VO", "PEN", "NV"))) {
                                            $modal_name = "#modal-voucher";
                                        } else if ($t->CDNo == "SO") {
                                            $modal_name = "#modal-standing-order-donation";
                                        } else if ($t->CDNo == "Cd" || $t->CDNo == "Ch") {
                                            $modal_name = "#modal-company-donation";
                                        } else {
                                            $modal_name = "";
                                        }

                                        $type = $t->description;

                                        $data .= $t->id . "||";
                                        $data .= $t->Name . "||";
                                        //$data .= date_create_from_format('j-n-y', $rows1[$i]['datetime'])->format('j-n-Y') . "||";
                                        $data .= date('j-n-Y', strtotime($t->DateTime)) . "||";
                                        $data .= showBalance(abs($t->Amount)) . "||";
                                        $data .= $t->Voucher . "||";
                                        $data .= $t->StandingOrderType . ' ' . $t->NumberOfPayments . "||";
                                        $data .= $t->ClientComments . "||";
                                        $data .= $t->OfficeComments . "||";
                                        $data .= $t->CharityNumber . "||";

                                        if ($t->Voucher && substr($t->Voucher, 0, 1) == '9') {
                                            $status = 'online request';
                                        }
                                        if ($i >= ($k - 10) && $i < $k) {
                                            ?>
                                            <tr class="modal-show transaction_history-row" data-toggle="modal" data-target="<?php echo $modal_name; ?>" data-id="<?php echo $data; ?>" data-type="<?php echo $t->CDNo; ?>">
                                                <td>
                                                    <a href="javascript:void(0);" >
                                                        <div class="date"><?php echo date('j-n-y', strtotime($t->DateTime)); ?></div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" >
                                                        <div class="desc-table">
                                                            <h2 class="title"><?php echo $t->Description; ?></h2>
                                                            <h3 class="subtitle transaction-type-label"><?php echo $type; ?></h3>
                                                        </div><!-- /desc-table -->
                                                    </a>
                                                </td>
                                                <!--<td class="hidden-xs"></td>-->
                                                <td class="desktop-align-center <?php echo getBalanceColor(number_format($t->Amount, 2)); ?>">
                                                    <a href="javascript:void(0);" >
                                                        <span class="balance-transition">
                                                            <?php echo showBalance($t->Amount); ?>
                                                            <i class="fa fa-caret-up" aria-hidden="true"></i>
                                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $i++;
                                    }
                                    //$cnt = $k - 1;
                                }
                                ?>
                            </tbody>
                        </table>

                    </div><!-- /container-table -->
                    <nav class="navigation-transactions hidden-xs" aria-label="Page navigation  ">
                        <ul class="pagination nav-transactions">
                            <?php
                            $class = "class='pag-active page external-lkn'";
                            $class1 = "class='page external-lkn'";
                            /* $class = "class='pag-active page'";
                              $class1 = "class='page'"; */
                            $parameter = '&charityId=' . $charity_id;
                            if (isset($n)) {
                                $total_row = $n;
                            } else {
                                $total_row = count($tl);
                            }
                            $per_page = 10;
                            $total_page = ceil($total_row / $per_page);
                            if ($total_page > 1) {
                                ?>
                                <li>
                                    <?php if ($page > 1) { ?>
                                        <a href="transactions-history.php?page=<?php
                                        echo $page - 1;
                                        echo $parameter;
                                        ?>" class='page external-lkn' aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    <?php } ?>
                                </li>
                                <li><a href="transactions-history.php?page=1<?php echo $parameter; ?>" <?php
                                    if ($page == 1)
                                        echo $class;
                                    else
                                        echo $class1;
                                    ?> id="page1">1</a></li>
                                       <?php
                                       for ($i = 2; $i <= $total_page; $i++) {
                                           ?>
                                    <li><a href="transactions-history.php?page=<?php
                                        echo $i;
                                        echo $parameter;
                                        ?>" 
                                           <?php
                                           if ($i == $page)
                                               echo $class;
                                           else
                                               echo $class1;
                                           ?> ><?php echo $i; ?> </a></li>
                                        <?php
                                    }
                                    ?>
                                <li>
                                    <?php if ($page < $total_page) { ?>
                                        <a href="transactions-history.php?page=<?php
                                        echo $page + 1;
                                        echo $parameter;
                                        ?>" class='page external-lkn' aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    <?php } ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </nav><!-- /navigation-transactions -->
                    <?php
                }
                ?>
            </div><!-- /col -->
        </div><!-- /row -->
    </div><!-- /container-fluid -->
</main>	
<div class="modal-search modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>    	
            <div class="modal-body">
                <form class="form-modal-search">
                    <div class="form-group">
                        <label for="" class="label">TRANSACTION ID</label>
                        <div class="row-input">
                            <a href="#" class="checkbox-input">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="input" placeholder="For a specific transaction.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">CHARITY NAME</label>
                        <div class="row-input">
                            <a href="#" class="checkbox-input">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="input" placeholder="Please enter the name of the charity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">AMOUNT DONATED</label>
                        <div class="row-input">
                            <a href="#" class="checkbox-input">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="input" placeholder="For a specific amount that has been donated.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">PERSONAL NOTES</label>
                        <div class="row-input">
                            <a href="#" class="checkbox-input">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="input" placeholder="Search your personal notes">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">VOUCHER NUMBER</label>
                        <div class="row-input">
                            <a href="#" class="checkbox-input">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="input" placeholder="Enter voucher number or range (from and to)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">BOOK VOUCHER NUMBER</label>
                        <div class="row-input">
                            <a href="#" class="checkbox-input">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="input" placeholder="To display all vouchers in a book.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label">TRANSACTION TYPE</label>
                        <div class="row-input">
                            <a href="#" class="checkbox-input">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </a>
                            <input type="text" class="input" placeholder="Select the type of transactions ">
                        </div>
                    </div>
                    <a href="transactions-result.php" class="btn-search">Search Transactions</a>
                </form>
            </div><!-- /modal-body -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-search -->

<?php include 'inc/online-donation-modal.php' ?>
<?php include 'inc/give-as-you-earn-modal.php' ?>
<?php include 'inc/giftaid-rebate-modal.php' ?>
<?php include 'inc/comision-modal.php' ?>
<?php include 'inc/voucher-book-modal.php' ?>
<?php include 'inc/voucher-modal.php' ?>
<?php include 'inc/standing-order-donation.php' ?>
<?php include 'inc/company-donation-modal.php' ?>