<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'inc/funcs.inc.php';

session_start();

User::LoginCheck();
$id = $_REQUEST['id'];
if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

/* $qry = "";
  $qry .= "SELECT sm.*,c.name FROM so_master sm ";
  $qry .= " LEFT JOIN charities c on sm.charity_id = c.remote_charity_id";
  $qry .= " WHERE sm.id = " . $id;
  $result = mysql_query($qry);
  $so_master_row = mysql_fetch_row($result, MYSQL_ASSOC); */

$transactionlist = new TransactionList();
$so_master_row = $transactionlist->getSOMasterList($id);

/* $qry = "";
  $qry .= " SELECT st.*,u.username,c.name";
  $qry .= " FROM so_trans st";
  $qry .= " LEFT JOIN so_master sm on st.sto_id = sm.id";
  $qry .= " LEFT JOIN users u on st.account = u.id";
  $qry .= " LEFT JOIN charities c on st.charity_id = c.remote_charity_id";
  $qry .= " WHERE st.sto_id = '" . $id . "' ORDER BY st.id DESC";
  $result = mysql_query($qry);
  $count = mysql_num_rows($result); */
$transactionlist = new TransactionList();
$sotl = $transactionlist->getSOtransactionList($id);
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(document).on('click', '.standing-orders', function () {
            var modaldata = jQuery(this).data('id');
            var row_arr = modaldata.split('||');
            jQuery('#modal_beneficiary').html(row_arr[0]);
            jQuery('#modal_date_paid').html(row_arr[1]);
            jQuery('#modal_amount').html(row_arr[2]);
            jQuery('#modal_payments_number').html(row_arr[3]);
            jQuery('#modal_notes_aac').html(row_arr[4]);
            jQuery('#modal_charity_notes').html(row_arr[5]);
        });
    });
</script>
<main class="main-transactions main-standing-orders-transactions content-desktop" >
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
                    <div class="title-standing-orders-transactions">
                        <h3 class="title-transactions"><?php echo "STANDING ORDER " . $so_master_row[0]->id . " FOR " . $so_master_row[0]->name . "<span>" . showBalance($so_master_row[0]->amount) . ", every " . showInterval($so_master_row[0]->freq) . ". " . $so_master_row[0]->count . "/" . $so_master_row[0]->times . " many payments so far."; ?></span></h3>
                    </div><!-- /title-transactions-result -->
                    <div class="clear"></div>
                </div><!-- /row  -->	
            </div><!-- /container  -->
        </header>
    </div><!-- /header-fixed -->

    <!-- AACDESIGN -->
    <div id="transactions-navigation-desktop" class="hidden-xs transactions-navigation-desktop">
        <div class="row">
            <div class="col-md-12">
                <a href="standing-orders.php" class="go-back go-back-transactions ">&lt; Back</a>
            </div>
            <div class="col-md-12">
                <div class="title-standing-orders-transactions">
                    <h3 class="title-transactions"><?php echo "STANDING ORDER " . $so_master_row[0]->id . " FOR " . $so_master_row[0]->name . "<span>" . showBalance($so_master_row[0]->amount) . ", every " . showInterval($so_master_row[0]->freq) . ". " . $so_master_row[0]->count . "/" . $so_master_row[0]->times . " many payments so far."; ?></span></h3>
                </div><!-- /title-transactions-result -->
            </div><!-- / col 6 -->
            <div class="col-lg-7 col-md-8">
                    <div class="container-lkns-transactions">
                        <a href="#" class="lkn-amend">AMEND THIS STANDING ORDER</a>
                        <a href="#" class="lkn-cancel-order">CANCEL THIS STANDING ORDER</a>
                    </div>
                
            </div>

            <div class="col-lg-5 col-md-4 text-right margintop-standing-orders">
                <a href="PHPExcel_1.8.0_doc/export_excel.php?filename=csv" class="expert-csv-file">EXPORT DATA TO CSV FILE</a>
                <a href="PHPExcel_1.8.0_doc/export_excel.php?filename=xls" class="expert-xls-file">EXPORT DATA TO XLS FILE</a>
            </div><!-- / col 6 -->
        </div><!-- / row -->
    </div><!-- /transactions-navigation-desktop -->

    <!-- END AACDESIGN -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">

                <!-- AACDESIGN -->
                
                <div class="container-table">
                    <table class="table-transactions table table-condensed">
                        <thead class="hidden-xs "> 
                            <tr>
                                <th>DATE</th>
                                <th>TRANSACTION ID</th>
                                <th>AMOUNT</th>
                                <th>PROGRESS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-toggle="modal" data-target="#modal-standing-order-donation" >
                                    <a href="#" >
                                        <div class="date">1-7-16</div>
                                    </a>
                                </td>
                                <td class="td-center" data-toggle="modal" data-target="#modal-standing-order-donation" >
                                    3847
                                </td>
                                <td class="desktop-align-center balance-down" data-toggle="modal" data-target="#modal-standing-order-
                                donation" >
                                    <a href="#" >
                                        <span class="balance-transition">
                                            £ 990.00
                                            <i class="fa fa-caret-up" aria-hidden="true"></i>
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </td>
                                <td class="hidden-xs td-interval">
                                    <span class="date-interval">1/2 PAYMENTS</span>
                                </td>
                            </tr>                   
                        </tbody>

                    </table>
                </div>

                <!-- END AACDESIGN -->

                <?php
                if (count($sotl) > 0) {
                    $k = $page * 10;
                    $i = ($page - 1) * 10;
                    $i = 0;
                    ?>
                    <div class="container-table">
                        <table class="table-transactions table table-condensed">
                            <thead class="hidden-xs "> 
                                <tr>
                                    <th>DATE</th>
                                    <th class="desktop-align-left">ID</th>
                                    <th>CHARITY</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($sotl as $t) {
                                    $data = "";
                                    $id = $t->id;
                                    //$request = $row['Request'];
                                    $beneficiary = $t->name;
                                    $amount = number_format($t->amount, 2);
                                    $date = date('d-m-y', strtotime($t->transdate));
                                    //$notes_aac = $row['ClientComments'];
                                    //$notes_charity = $row['OfficeComments'];

                                    /* $data .= $beneficiary . "||";
                                      $data .= $date . "||";
                                      $data .= '£ '.$amount . "||";
                                      $data .= "" . "||";
                                      $data .= $notes_aac . "||";
                                      $data .= $notes_charity . "||"; */
                                    if ($i >= ($k - 10) && $i < $k) {
                                        ?>
                                        <tr class="standing-orders" data-id="<?= $data; ?>" data-toggle="modal" data-target="#modal-standing-order-donation">
                                            <td>
                                                <a href="javascript:void(0);" >
                                                    <div class="date"><?php echo $date; ?></div>
                                                </a>
                                            </td>
                                            <td class="hidden-xs"><?php echo $id; ?></td>
                                            <td>
                                                <a href="javascript:void(0);" >
                                                    <div class="desc-table">
                                                        <h2 class="title"><?php echo $beneficiary; ?></h2>
                                                        <h3 class="subtitle"><?php //echo $request; ?></h3>
                                                    </div><!-- /desc-table -->
                                                </a>
                                            </td>
                                            <td class="desktop-align-center balance-down">
                                                <a href="javascript:void(0);" >
                                                    <span class="balance-transition">
                                                        <?php echo showBalance($amount); ?>
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
                                ?>
                            </tbody>
                        </table>
                        <nav class="navigation-transactions hidden-xs" aria-label="Page navigation  ">
                            <ul class="pagination nav-transactions">
                                <?php
                                $class = "class='pag-active page external-lkn'";
                                $class1 = "class='page external-lkn'";
                                /* $class = "class='pag-active page'";
                                  $class1 = "class='page'"; */
                                $parameter = '&id=' . $id;
                                $total_row = count($sotl);

                                $per_page = 10;
                                $total_page = ceil($total_row / $per_page);
                                if ($total_page > 1) {
                                    ?>
                                    <li>
                                        <?php if ($page > 1) { ?>
                                            <a href="standing-orders-transactions.php?page=<?php
                                            echo $page - 1;
                                            echo $parameter;
                                            ?>" class='page external-lkn' aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        <?php } ?>
                                    </li>
                                    <li><a href="standing-orders-transactions.php?page=1<?php echo $parameter; ?>" <?php
                                        if ($page == 1)
                                            echo $class;
                                        else
                                            echo $class1;
                                        ?> id="page1">1</a></li>
                                           <?php
                                           for ($i = 2; $i <= $total_page; $i++) {
                                               ?>
                                        <li><a href="standing-orders-transactions.php?page=<?php
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
                                            <a href="standing-orders-transactions.php?page=<?php
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
                    </div><!-- /container-table -->
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