<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';http://devdb.exceedit.co.uk/achisomoch/invite-a-friend.php
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
if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

$transactionlist = new TransactionList();

$transactionlist->filters[] = 'UserName="' . intval($user->Username) . '" ';
$transactionlist->filters[] = 'CDNo="PEN" ';


$transactionlist->sortby = $sort_fieldname;
$transactionlist->sortorder = $sort_direction;
$transactionlist->SetPage($page);

$ptl = $transactionlist->ListItems();
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(document).on('click', '.pending-transaction-row', function () {
            var modal_data = jQuery(this).data('id');
            var modal_type = jQuery(this).data('type');
            var row_arr = modal_data.split('||');
            //if (modal_type == "SO") {
            jQuery('#modal_beneficiary').html(row_arr[0]);
            jQuery('#modal_date_paid').html(row_arr[1]);
            jQuery('#modal_amount').html(row_arr[2]);
            jQuery('#modal_payments_number').html(row_arr[4]);
            if (row_arr[5] == "") {
                jQuery('#modal_notes_aac').html("No Notes have been added");
            } else {
                jQuery('#modal_notes_aac').html(row_arr[5]);
            }
            if (row_arr[6] == "") {
                jQuery('#modal_charity_notes').html("No Notes have been added");
            } else {
                jQuery('#modal_charity_notes').html(row_arr[6]);
            }
            //}
        });
    });
</script>
<main class="main-transactions content-desktop main-transactions-pending" >
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
                    <div class="title-transactions-result">
                        <h3 class="title-transactions">PENDING</h3>
                    </div><!-- /title-transactions-result -->
                    <div class="clear"></div>
                </div><!-- /row  -->	
            </div><!-- /container  -->
        </header>
    </div><!-- /header-fixed -->
    <?php
//    $transactionlist = new TransactionList();
//    $ptl = $transactionlist->getPendingTransactionList($user->Username);

    /* $sql = "";
      $sql .= " SELECT a.*,c.Name";
      $sql .= " FROM aac_requests a ";
      $sql .= " LEFT JOIN charities c on c.remote_charity_id = a.RemoteCharityID";
      $sql .= " LEFT JOIN users u on u.Username = a.Username";
      $sql .= " WHERE a.Username = '" . $user->Username . "' AND a.ResultCode = 'Pending' order by a.id desc";
      $result = mysql_query($sql); */
    //echo 'count:' . mysql_num_rows($result);
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="container-table">
                    <h2 class="title-orders">Pending Transactions</h2>
                    <?php
                    if (count($ptl) > 0) {
                        //$cnt = 0;
                        $k = $page * 10;
                        $i = ($page - 1) * 10;
                        $i = 0;
                        ?>
                        <table class="table-transactions table table-condensed">
                            <thead> 
                                <tr>
                                    <th>DATE</th>
                                    <th>DESCRIPTION</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($ptl as $t) {
                                    $data = "";
                                    $date = date('j-n-y', strtotime($t->DateTime));
                                    $charity_id = $t->CharityNumber;
                                    $beneficiary = $t->Name;
                                    $type = 'PEN';
                                    $amount = number_format($t->Amount, 2);

                                      $data .= $beneficiary . "||";
                                      $data .= $date . "||";
                                      $data .= showBalance($amount) . "||";
                                      $data .= $row['Voucher'] . "||";
                                      $data .= $row['StandingOrderType'] . ' ' . $row['NumberOfPayments'] . "||";
                                      $data .= $row['ClientComments'] . "||";
                                      $data .= $row['OfficeComments'] . "||"; 
                                    //if ($i >= ($k - 10) && $i < $k) {

										$data = $t->id;
										$type='TR';
                                        ?>
                                        <tr class="<?php echo getBalanceColor(number_format($amount, 2)); ?> modal-show pending-transaction-row" data-toggle="modal" data-target="#modal-voucher" data-id="<?php echo $data; ?>" data-type="TR">
                                            <?php /* <tr class="<?php echo getBalanceColor(number_format($amount, 2)); ?> modal-show pending-transaction-row" data-toggle="modal" data-target="#modal-standing-order-donation" data-id="<?php echo $data; ?>" data-type="<?php echo $type; ?>"> */ ?>
                                            <td>
                                                <a href="javascript:void(0);">
                                                    <div class = "date"><?php echo $date; ?></div>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" >
                                                    <div class="desc-table">
                                                        <h2 class="title">
                                                            <?php

															echo $t->Description;

                        
                                                            ?>
                                                        </h2>
                                                        <h3 class="subtitle transaction-type-label"><span><?php echo 'Pending'; //getTransactionType($type); ?></span></h3>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="balance-pending amount-td">
                                                <a href="javascript:void(0);" >
                                                    <span class="balance-transition">
                                                        <?php
                                                            echo $t->FormatAmount();
                                                            echo '<i class = "fa fa-caret-up" aria-hidden = "true"></i>';
                                                            echo '<i class = "fa fa-caret-down" aria-hidden = "true"></i>';
                                                            echo '<i class = "fa fa-caret-right" aria-hidden = "true"></i>';
                                                        ?>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    //}
                                    $i++;
                                }
                                //$cnt = $k - 1;
                                ?>
                            </tbody>
                        </table>
    <nav class="navigation-transactions hidden-xs" aria-label="Page navigation  ">
        <ul class="pagination nav-transactions"><li>
            <?php

			$pageNavOptions  = array(
				'NoItemsText'=>'',
				'MaxVisiblePageNums'=>5,
				'PrevPageText'=>'&lt;',
				'NextPageText'=>'&gt;',
				'FirstPageText'=>'&laquo;',
				'LastPageText'=>'&raquo;',
				'ShowAllText'=>'',
				'ShowAllAlign'=>'',
				'LeadingText'=>'',
				'SuffixText'=>'',
				'PageNumSeperator'=>'</li><li>',
				'UseJavascriptFunction'=>'',
			);


			echo UI::makePageNav('transactions-pending.php',$page,$transactionlist->PageCount(),false,$_GET,$pageNavOptions);
			?>
        </li></ul>
    </nav><!-- /navigation-transactions -->
                        <?php
                    } else {
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
                    }
                    ?>
                </div><!--/container-table -->
            </div><!--/col -->
        </div><!--/row -->
    </div><!--/container-fluid -->
</main>
<div class = "modal-search modal fade" id = "modal-search" tabindex = "-1" role = "dialog" aria-labelledby = "myModalLabel">
    <div class = "modal-dialog" role = "document">
        <div class = "modal-content">
            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                    <span aria-hidden = "true">&times;
                    </span>
                </button>
            </div>
            <div class = "modal-body">
                <form class = "form-modal-search">
                    <div class = "form-group">
                        <label for = "" class = "label">TRANSACTION ID</label>
                        <div class = "row-input">
                            <a href = "#" class = "checkbox-input">
                                <i class = "fa fa-check" aria-hidden = "true"></i>
                            </a>
                            <input type = "text" class = "input" placeholder = "For a specific transaction.">
                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "" class = "label">CHARITY NAME</label>
                        <div class = "row-input">
                            <a href = "#" class = "checkbox-input">
                                <i class = "fa fa-check" aria-hidden = "true"></i>
                            </a>
                            <input type = "text" class = "input" placeholder = "Please enter the name of the charity">
                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "" class = "label">AMOUNT DONATED</label>
                        <div class = "row-input">
                            <a href = "#" class = "checkbox-input">
                                <i class = "fa fa-check" aria-hidden = "true"></i>
                            </a>
                            <input type = "text" class = "input" placeholder = "For a specific amount that has been donated.">
                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "" class = "label">PERSONAL NOTES</label>
                        <div class = "row-input">
                            <a href = "#" class = "checkbox-input">
                                <i class = "fa fa-check" aria-hidden = "true"></i>
                            </a>
                            <input type = "text" class = "input" placeholder = "Search your personal notes">
                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "" class = "label">VOUCHER NUMBER</label>
                        <div class = "row-input">
                            <a href = "#" class = "checkbox-input">
                                <i class = "fa fa-check" aria-hidden = "true"></i>
                            </a>
                            <input type = "text" class = "input" placeholder = "Enter voucher number or range (from and to)">
                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "" class = "label">BOOK VOUCHER NUMBER</label>
                        <div class = "row-input">
                            <a href = "#" class = "checkbox-input">
                                <i class = "fa fa-check" aria-hidden = "true"></i>
                            </a>
                            <input type = "text" class = "input" placeholder = "To display all vouchers in a book.">
                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "" class = "label">TRANSACTION TYPE</label>
                        <div class = "row-input">
                            <a href = "#" class = "checkbox-input">
                                <i class = "fa fa-check" aria-hidden = "true"></i>
                            </a>
                            <input type = "text" class = "input" placeholder = "Select the type of transactions ">
                        </div>
                    </div>
                    <a href = "transactions-result.php" class = "btn-search">Search Transactions</a>
                </form>
            </div><!--/modal-body -->
        </div><!--/modal-content -->
    </div><!--/modal-dialog -->
</div><!--/modal-search -->

<?php include 'inc/online-donation-modal.php' ?>
<?php include 'inc/give-as-you-earn-modal.php' ?>
<?php include 'inc/giftaid-rebate-modal.php' ?>
<?php include 'inc/comision-modal.php' ?>
<?php include 'inc/voucher-book-modal.php' ?>
<?php include 'inc/voucher-modal.php' ?>
<?php include 'inc/standing-order-donation.php' ?>
<?php include 'inc/company-donation-modal.php' ?>