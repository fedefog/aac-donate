<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'inc/funcs.inc.php';
session_start();

User::LoginCheck();
$user = new User();
$user = User::GetInstance();

if ($_REQUEST['field'] && $_REQUEST['search']) {
    $search = $_REQUEST['search'];
    $field = $_REQUEST['field'];
} else {
    if ($_REQUEST['transaction_id']) {
        $search = $_REQUEST['transaction_id'];
        $field = $id;
    } else if ($_REQUEST['charity_name'] || $_REQUEST['charity_name']=='') {
        $search = $_REQUEST['charity_name'];
        $field = c5;
    } else if ($_REQUEST['amount_donated']) {
        $search = $_REQUEST['amount_donated'];
        $field = c3;
    } else if ($_REQUEST['personal_note']) {
        $search = $_REQUEST['personal_note'];
    } else if ($_REQUEST['voucher_no']) {
        $search = $_REQUEST['voucher_no'];
        $field = c4;
    } else if ($_REQUEST['book_voucher_no']) {
        $search = $_REQUEST['book_voucher_no'];
    } else if ($_REQUEST['transaction_type']) {
        $search = $_REQUEST['transaction_type'];
        $field = c2;
    }
}

$td = new TransactionDetailList();
$transaction = $td->getTransactionDetailByAccountName($user->Reference);

foreach ($transaction as $tr) {
    $balance = $tr->bal;
}
$rowBal = $balance;

if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
if($field=='c5' && $search==''){
}

$transactionlist = new TransactionList();
$tl = $transactionlist->getTransactionListSearch($user->Username, $search, $field);
for ($i = 0; $i < count($tl); $i++) {

    $rows1[$i][amount] = $tl[$i]->c3;
    $rows1[$i][date] = date_create_from_format('Y-m-d i:s:u', $tl[$i]->c1)->format('d/M/Y');
    $rows1[$i][type] = $tl[$i]->c2;
    $rows1[$i][name] = $tl[$i]->c5;
    $rows1[$i][vchno] = $tl[$i]->c4;
    $rowBal -= $rows1[$i][amount];
    $dateObj = DateTime::createFromFormat('d/M/Y', $rows1[$i][date]);
    $rows1[$i][date1] = $dateObj->format('Y-m-d');
}
?>
<main class="main-transactions main-transactions-result content-desktop" >

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

                        <h3 class="title-transactions">SEARCH RESULTS</h3>

                    </div><!-- /title-transactions-result -->

                    <div class="clear"></div>

                </div><!-- /row  -->	

            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->

    <div id="transactions-navigation-desktop" class="hidden-xs transactions-navigation-desktop">

        <div class="row">

            <div class="col-md-6">

                <h2 class="title-transactions-desktop">Search Result </h2>

                <ul class="nav-transactions">

                    <li class="nav-transactions-li">

                        <a href="transactions-all.php" class="nav-transactions-lkn active">all</a>

                    </li>

                    <li class="nav-transactions-li">

                        <a href="transactions-in.php" class="nav-transactions-lkn">in</a>

                    </li>

                    <li class="nav-transactions-li">

                        <a href="transactions-out.php" class="nav-transactions-lkn">out</a>

                    </li>

                </ul>

            </div><!-- / col 6 -->

            <div class="col-md-6 text-right">
                <a href="#" class="expert-csv-file">EXPORT DATA TO CSV FILE</a>
                <a href="#" class="expert-xls-file">EXPORT DATA TO XLS FILE</a>
            </div><!-- / col 6 -->

        </div><!-- / row -->

    </div><!-- /transactions-navigation-desktop -->

    <div class="container-fluid top-center-content ">

        <div class="row">

            <div class="col-xs-12">

                <ul class="navigator-transactions">

                    <li class="navigator-transactions-li">

                        <a href="#" class="navigator-transactions-lkn lkn-recent active">RECENT</a>

                    </li>

                    <li class="navigator-transactions-li">

                        <a href="#" id="dates-bt-modal" class="navigator-transactions-lkn visible-xs">DATES</a>
                        <input type="text"  id="config-date" class="form-control hidden-xs">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar hidden-xs"></i>
                    </li>

                    <li class="navigator-transactions-li">

                        <a href="#" class="navigator-transactions-lkn lkn-search visible-xs" data-toggle="modal" data-target="#modal-search" >SEARCH</a>

                    </li>

                    <li class="navigator-transactions-li hidden-xs">

                        <a href="#" class="navigator-transactions-lkn lkn-search  lkn-seach-desktop btn-dropdown-search"  >SEARCH</a>

                    </li>

                    <li class="navigator-transactions-li navigator-transactions-sortby ">

                        <a href="#" class="navigator-transactions-lkn lkn-sortby">
                            <span class="text hidden-xs">SORT BY</span>
                            <i class="fa fa-sort-amount-desc" aria-hidden="true"></i>

                        </a>

                        <div class="drop-down-sort">

                            <a href="#" class="navigator-transactions-lkn lkn-sortby">
                                <span class="text hidden-xs">SORT BY</span>
                                <i class="fa fa-sort-amount-desc" aria-hidden="true"></i>

                            </a>

                            <div class="container-sortby">

                                <ul class="list-sortby">
                                    <li class="sortby-li">
                                        <h2 class="title-sortby">SORT BY</h2>
                                    </li>
                                    <li class="sortby-li">
                                        <a href="#" class="sortby-lkn">Date (Recent - Furthest)</a>
                                    </li>
                                    <li class="sortby-li">
                                        <a href="#" class="sortby-lkn">Date (Furthest - Recent)</a>
                                    </li>
                                    <li class="sortby-li">
                                        <a href="#" class="sortby-lkn">Amount (High - Low)</a>
                                    </li>
                                    <li class="sortby-li">
                                        <a href="#" class="sortby-lkn">Amount (Low - High)</a>
                                    </li>
                                    <li class="sortby-li">
                                        <a href="#" class="sortby-lkn">Charity Name (A - Z)</a>
                                    </li>
                                    <li class="sortby-li">
                                        <a href="#" class="sortby-lkn">Charity Name (Z - A)</a>
                                    </li>
                                </ul>

                            </div><!-- /container-sortby -->

                        </div><!-- /drop-down-sort -->

                    </li>

                </ul>

            </div><!-- / col 12 -->

        </div><!-- / row -->

    </div><!-- / top center content -->

    <div class="container-fluid">

        <div class="row">

            <div class="col-xs-12">

                <div class="container-table">

                    <table class="table-transactions table table-condensed">

                        <thead class="hidden-xs "> 
                            <tr>
                                <th>DATE</th>
                                <th>DESCRIPTION</th>
                                <th>AMOUNT</th>
                                <th class="hidden-xs">BALANCE AFTER TRANSACTION</th>
                                <th class="hidden-xs">TYPE</th>
                                <th class="hidden-xs">ACTION</th>
                            </tr>
                        </thead>						
                        <tbody>
                            <?php
                            if ($tl) {
                                $k = $page * 10;
                                $i = ($page - 1) * 10;
                                if (isset($n)) {
                                    $j = $n;
                                } else {
                                    $j = count($tl);
                                }

                                if ($k > $j) {
                                    $k = $j;
                                }

                                for ($m = 0; $m < $i; $m++) {
                                    $rowBal += $rows1[$m][amount];
                                }

                                //$lastRowDate = '';
                                for ($i; $i < $k; $i++) {
                                    $rowDate = $rows1[$i][date];
                                    /* if ($rowDate != $lastRowDate) {
                                      $lastRowDate = $rowDate;
                                      } else {
                                      $rowDate = '';
                                      } */
                                    $rowtype = $rows1[$i][type];
                                    if ($rowtype == 'VCH') {
                                        $rowtype = 'VOUCHER';
                                    }
                                    $amt = $rows1[$i][amount];
                                    $rowBal += $amt;
                                    $balanceAmt = $rowBal;
                                    $name = $rows1[$i][name];
                                    $vchno = $rows1[$i][vchno];
                                    ?>
                                    <tr class="balance-down modal-show">
                                        <td data-toggle="modal" data-target="#modal-voucher" >
                                            <a href="#"  >
                                                <div class="date"><?php echo $rowDate; ?></div>
                                            </a>
                                        </td>
                                        <td data-toggle="modal" data-target="#modal-voucher" >
                                            <a href="#"  >
                                                <div class="desc-table">
                                                    <h2 class="title"><?php echo $name; ?></h2>
                                                    <h3 class="subtitle">VOUCHER </h3>
                                                </div><!-- /desc-table -->
                                            </a>
                                        </td>
                                        <td class="amount-td" data-toggle="modal" data-target="#modal-voucher" >
                                            <a href="#"  >
                                                <span class="balance-transition voucher-balance">
                                                    £ <?php echo number_format($amt, 2); ?>
                                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                                            <a href="#" >
                                                <span class="balance-transition">£
                                                    <?php echo number_format($balanceAmt, 2); ?>
                                                </span>
                                            </a>
                                        </td>
                                        <td class="type-td">
                                            <p class="type-transactions"><?php echo $rowtype; ?></p>
                                        </td>
                                        <td class="action-edit hidden-xs">
                                            <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                                            <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                                            <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                                        </td>
                                <input type="hidden" name="vchnumber" class="vch-number" value="<?php echo $vchno; ?>">
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <?php /* <tr class="balance-down">
                          <td data-toggle="modal" data-target="#modal-standing-order-donation" >
                          <a href="#" >
                          <div class="date">1-7-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-standing-order-donation" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Initiation Society</h2>
                          <h3 class="subtitle">STANDING ORDER </h3>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-standing-order-donation" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 990.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>

                          <tr class="balance-down">
                          <td data-toggle="modal" data-target="#modal-voucher-book" >
                          <a href="#" >
                          <div class="date">14-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-voucher-book" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">£1 Voucher Book £50</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-voucher-book" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 50.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-up" >
                          <td data-toggle="modal" data-target="#modal-comision" >
                          <a href="#" >
                          <div class="date">12-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-comision" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Commission</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-comision" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 21.56
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-up" >
                          <td data-toggle="modal" data-target="#modal-giftaid-rebate" >
                          <a href="#" >
                          <div class="date">9-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-giftaid-rebate" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Giftaid Rebate</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-giftaid-rebate" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 233
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-up" >
                          <td data-toggle="modal" data-target="#modal-give-as-you-earn" >
                          <a href="#" >
                          <div class="date">1-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-give-as-you-earn" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Give as You Earn</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-give-as-you-earn" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-down">
                          <td data-toggle="modal" data-target="#modal-online-donation" >
                          <a href="#" >
                          <div class="date">1-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-online-donation" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Menorah Grammar</h2>
                          <h3 class="subtitle">ONLINE DONATION </h3>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-online-donation" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 222.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-down">
                          <td data-toggle="modal" data-target="#modal-account-transfer" >
                          <a href="#" >
                          <div class="date">1-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-account-transfer" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Account Transfer</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-account-transfer" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 200.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-up" >
                          <td data-toggle="modal" data-target="#modal-company-donation" >
                          <a href="#" >
                          <div class="date">1-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-company-donation" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Company Donation</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-company-donation" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 200.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>

                          <tr class="balance-up" >
                          <td data-toggle="modal" data-target="#modal-charity-donation" >
                          <a href="#" >
                          <div class="date">1-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-charity-donation" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Charity Donation</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-charity-donation" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 200.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-up" >
                          <td data-toggle="modal" data-target="#modal-account-transfer" >
                          <a href="#" >
                          <div class="date">1-6-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-account-transfer" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Account Transfer</h2>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-account-transfer" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 200.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr>
                          <tr class="balance-pending" >
                          <td data-toggle="modal" data-target="#modal-standing-order-donation" >
                          <a href="#" >
                          <div class="date">1-7-16</div>
                          </a>
                          </td>
                          <td data-toggle="modal" data-target="#modal-standing-order-donation" >
                          <a href="#" >
                          <div class="desc-table">
                          <h2 class="title">Kol Yaakov</h2>
                          <h3 class="subtitle">VOUCHER <span>PENDING</span></h3>
                          </div><!-- /desc-table -->
                          </a>
                          </td>
                          <td class="amount-td" data-toggle="modal" data-target="#modal-standing-order-donation" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 990.00
                          <i class="fa fa-caret-up" aria-hidden="true"></i>
                          <i class="fa fa-caret-down" aria-hidden="true"></i>
                          <i class="fa fa-caret-right" aria-hidden="true"></i>
                          </span>
                          </a>
                          </td>
                          <td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
                          <a href="#" >
                          <span class="balance-transition">
                          £ 550.00
                          </span>
                          </a>
                          </td>
                          <td class="type-td hidden-xs">
                          <p class="type-transactions">VOUCHER</p>
                          </td>
                          <td class="action-edit hidden-xs">
                          <a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                          <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
                          <a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
                          </td>
                          </tr> */ ?>						
                        </tbody>

                    </table>

                    <nav class="navigation-transactions hidden-xs" aria-label="Page navigation  ">
                        <ul class="pagination">
                            <?php
                            $class = "class='pag-active external-lkn'";
                            $class1 = "class='external-lkn'";
                            $parameter = null;
                            if ($search && $field) {
                                $parameter = "&&field=" . $field . "&&search=" . $search;
                            }
                            if ($sort && $fieldname) {
                                $parameter = '&&sort=' . $sort . '&&fieldname=' . $fieldname;
                            }
                            if ($_REQUEST['startdate'] && $_REQUEST['enddate']) {
                                $parameter = '&&startdate=' . $_REQUEST['startdate'] . '&&enddate=' . $_REQUEST['enddate'];
                            }
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
                                        <a href="transactions-result.php?page=<?php
                                        echo $page - 1;
                                        echo $parameter;
                                        ?>" class='page' aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    <?php } ?>
                                </li>
                                <li><a href="transactions-result.php?page=1<?php echo $parameter; ?>" <?php
                                    if ($page == 1)
                                        echo $class;
                                    else
                                        echo $class1;
                                    ?> id="page1">1</a></li>
                                       <?php
                                       for ($i = 2; $i <= $total_page; $i++) {
                                           ?>
                                    <li><a href="transactions-result.php?page=<?php
                                        echo $i;
                                        echo $parameter;
                                        ?>" <?php
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
                                        <a href="transactions-result.php?page=<?php
                                        echo $page + 1;
                                        echo $parameter;
                                        ?>" class='page' aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    <?php } ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>

                    </nav><!-- /navigation-transactions -->

                </div><!-- /container-table -->

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

<div class="modal-backdrop fade sort-back"></div>


<? include 'inc/online-donation-modal.php' ?>
<? include 'inc/give-as-you-earn-modal.php' ?>
<? include 'inc/giftaid-rebate-modal.php' ?>
<? include 'inc/comision-modal.php' ?>
<? include 'inc/voucher-book-modal.php' ?>
<? include 'inc/voucher-modal.php' ?>
<? include 'inc/standing-order-donation.php' ?>
<? include 'inc/company-donation-modal.php' ?>