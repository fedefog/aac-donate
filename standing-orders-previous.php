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

//$type['searchType'] = 'standingorder';
$req_charity_id = $_REQUEST['charity_id'];
$type['standingorder'] = 'standingorder';
$type['charity_id'] = $req_charity_id;
$trl = new AACRequestList();
$t = $trl->DoSearch($user, $type, 0);

$qry = "";
$qry .= " SELECT sm.*,u.username,c.name";
$qry .= " FROM so_master sm";
$qry .= " LEFT JOIN users u on u.id = sm.account";
$qry .= " LEFT JOIN charities c on sm.charity_id = c.remote_charity_id";
//$qry .= " WHERE sm.account = '76' ORDER BY sm.id DESC";
$qry .= " WHERE sm.account = '" . $user->id . "' ORDER BY sm.id DESC";

$result = mysql_query($qry);
$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = $row;
}
$t = $data;
//echo 'count:'.count($t);
//print_r($data);

if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function () {

<?php
$url = "PHPExcel_1.8.0_doc/export_excel.php?filename=csv";
$url1 = "PHPExcel_1.8.0_doc/export_excel.php?filename=xls";
$param = "";
$param .= "&search=so_current";
$param .= "&charity_id=" . $req_charity_id;
?>
        jQuery('#export_csv_so').attr("href", "<?php echo $url . $param; ?>");
        jQuery('#export_xls_so').attr("href", "<?php echo $url1 . $param; ?>");

        jQuery(document).on('click', '.balance-up', function () {
            var mydata = jQuery(this).data('id');
            var row_arr = mydata.split('||');
            jQuery('#modal_beneficiary1').html(row_arr[0]);
            jQuery('#modal_req_date1').html(row_arr[1]);
            jQuery('#modal_end_date1').html(row_arr[2]);
            jQuery('#modal_payments_set1').html(row_arr[3]);
            jQuery('#modal_total_donated_sf1').html(row_arr[4]);
            jQuery('#modal_total_donated_tb1').html(row_arr[5]);
            if (row_arr[6] == "") {
                jQuery('#modal_notes_aac1').html("No Notes have been added");
            } else {
                jQuery('#modal_notes_aac1').html(row_arr[6]);
            }
            if (row_arr[7] == "") {
                jQuery('#modal_charity_notes1').html("No Notes have been added");
            } else {
                jQuery('#modal_charity_notes1').html(row_arr[7]);
            }
        });

    });
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

    function cancelOrder(id) {
        //var url = "inc/ajax_cancel_standing_order.php?id=" + id + "&action=cancel";
        var url = "inc/ajax_cancel_standing_order.php";
        jQuery.ajax({
            type: 'POST',
            data: {'id': id, 'action': 'cancel'},
            url: url,
            success: function (data) {
                /*if(data == "1")
                 {
                 alert('Success');
                 }*/
            }
        });
    }
</script>
<?php
if (count($t) < 1) {
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
    exit;
}
?>
<table class="table-transactions table-standing-orders table table-condensed">
    <thead class="hidden-xs "> 
        <tr>
            <th class="text-left">ID</th>
            <th>CHARITY</th>
            <th>AMOUNT</th>
            <th class="hidden-xs">INTERVAL</th>
            <th class="hidden-xs">END DATE</th>
            <th class="hidden-xs"></th>
            <th class="hidden-xs">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($t)) {
            $k = $page * 10;
            $i = ($page - 1) * 10;
            $i = 0;
            $j = count($t);

            if ($k > $j) {
                $k = $j;
            }

            foreach ($tl as $t) {
                //if ($t[$i]->StandingOrderEndDate < time() && $t[$i]->StandingOrderEndDate != "" && $t[$i]->StandingOrderEndDate != 
                $cnt++;
                $data = "";
                $id = $t->id;
                $name = $t->name;
                $remote_charity_id = $t->charity_id;
                $amt = number_format($t->amount, 2);
                $interval = showInterval($t->freq);
                /* if ($t[$i]['freq'] == "M") {
                  $interval = 'Monthly';
                  } elseif ($t[$i]['freq'] == "2") {
                  $interval = '2 Monthly';
                  } elseif ($t[$i]['freq'] == "3") {
                  $interval = '3 Monthly';
                  } */
                //$interval = strtoupper($t->freq);
                //$end_date = $t[$i]['StandingOrderEndDate'] ? date('M-Y', $t[$i]['StandingOrderEndDate']) : '';
                /* if ($interval == 'MONTHLY') {
                  $interval = 'MONTH';
                  } */

                $data .= $name . "||";
                $data .= date('d-m-Y', $t->date) . "||";
                //$data .= $end_date . "||";
                $data .= $t->NumberOfPayments . "||";
                $data .= showBalance($t->TotalDonatedSoFar) . "||";
                $data .= showBalance($t->TotalToDonate) . "||";
                $data .= $t->ClientComments . "||";
                $data .= $t->OfficeComments . "||";
                //$balance_color = getBalanceColor($amt);
                //$balance_color = str_replace('balance-up', 'balance-down', $balance_color);
                if ($i >= ($k - 10) && $i < $k) {
                    ?>
                    <tr class="<?php echo getBalanceColor($amt, 2); ?>" data-id="<?= $data; ?>">
                        <?php /* <tr class="<?php echo $balance_color; ?>" data-id="<?= $data; ?>"> */ ?>
                        <td class="hidden-xs td-center">
                            <?php echo $id; ?>
                        </td>
                        <td data-toggle="modal" data-target="#modal-current-standing-order" >
                            <a href="#">
                                <div class="desc-table">
                                    <h2 class="title td-center"><?php echo $name; ?></h2>
                                    <h3 class="subtitle visible-xs">EVERY 2 MONTHS</h3>
                                </div><!-- /desc-table -->
                            </a>
                        </td>
                        <td  data-toggle="modal" data-target="#modal-current-standing-order" >
                            <a href="#" >
                                <span class="balance-transition ">
                                    <!--£ <?php //echo $amt;                 ?>-->
                                    <?php echo showBalance($amt); ?>
                                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </span>
                            </a>
                        </td>
                        <td class="hidden-xs td-interval">
                            <span class="date-interval">EVERY <?php echo strtoupper($interval); ?></span>
                        </td>
                        <td class="hidden-xs td-end-date">
                            <span class="text-end-date"><?php echo strtoupper($end_date); ?></span>
                        </td>
                        <td class="hidden-xs td-view-transaction">
                            <a href="standing-orders-transactions.php?id=<?php echo $id; ?>" class="external-lkn lkn-view-transaction">VIEW TRANSACTIONS</a>
                        </td>
                        <td class="action-edit hidden-xs">
                            <a href="make-a-donation.php?id=<?php echo $id; ?>" class="edit-transactions btn-trannsaction-accion external-lkn"></a>
                            <a href="javascript:void(0);" class="delete-transactions btn-trannsaction-accion" data-id="<?php echo $id; ?>" onClick="cancelStandingOrder('<?php echo $id; ?>');"></a>
                        </td>
                    </tr>
                    <?php
                }
                //}
                $i++;
            }
        }
        ?>
    </tbody>
</table>

<!-- AACDESING -->
    
<table class="table-transactions table-standing-orders table table-condensed">
    <thead class="hidden-xs "> 
        <tr>
            <th>ID</th>
            <th>CHARITY</th>
            <th>AMOUNT</th>            
            <th class="hidden-xs">INTERVAL</th>
            <th>DATE ENDED</th>
            <th class="hidden-xs">CURRENT SO TO BE PAID</th>
            <th class="hidden-xs"></th>
            <th class="hidden-xs">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <tr class="balance-down" data-id="">
            <td class="hidden-xs td-center">
                1938
            </td>
            <td data-toggle="modal" data-target="#modal-current-standing-order">
                <a href="#">
                    <div class="desc-table">
                        <h2 class="title td-center">Charity Name</h2>
                        <h3 class="subtitle visible-xs">EVERY 2 MONTHS</h3>
                    </div><!-- /desc-table -->
                </a>
            </td>
            <td data-toggle="modal" data-target="#modal-current-standing-order">
                <a href="#">
                    <span class="balance-transition ">
                        £ 1,290.00
                        <!--£ -->
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </span>
                </a>
            </td>
            <td class="hidden-xs td-interval">
                <span class="date-interval">EVERY 2 MONTHS</span>
            </td>
            <td class="hidden-xs td-interval">
                <span class="date-interval">NOV 2018</span>
            </td>
            <td class="hidden-xs td-end-date">
                <span class="to-be-paid">£ 1,290.00</span>
            </td>
            <td class="hidden-xs td-view-transaction">
                <a href="standing-orders-transactions.php?id=" class="external-lkn lkn-view-transaction">VIEW TRANSACTIONS</a>
            </td>
            <td class="action-edit hidden-xs">
                <a href="make-a-donation.php?id=" class="edit-transactions btn-trannsaction-accion external-lkn"></a>
                <a href="javascript:void(0);" class="delete-transactions btn-trannsaction-accion" data-id="" onclick="cancelStandingOrder('');"></a>
            </td>
        </tr>
                                        
    </tbody>

</table>    

<!-- END AACDESING -->

<nav class="navigation-transactions hidden-xs" aria-label="Page navigation  ">
    <ul class="pagination">
        <?php
        $class = "class='pag-active page-standing'";
        $class1 = "class='page-standing'";
        $total_row = count($tl);
        //$total_row = $cnt;
        $per_page = 10;
        $total_page = ceil($total_row / $per_page);
        if ($total_page > 1) {
            ?>
            <li>
                <?php if ($page > 1) { ?>
                    <a href="standing-orders-current.php?page=<?php echo $page - 1; ?>"
                       class='page-standing' aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php } ?>
            </li>
            <li><a href="standing-orders-current.php?page=1<?php echo $parameter; ?>"
                <?php
                if ($page == 1)
                    echo $class;
                else
                    echo $class1;
                ?> >1</a></li>
                <?php
                for ($i = 2; $i <= $total_page; $i++) {
                    ?>
                <li><a href="standing-orders-current.php?page=<?php echo $i; ?>"
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
                    <a href="standing-orders-current.php?page=<?php echo $page + 1; ?>"
                       class='page-standing' aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                <?php } ?>
            </li>
            <?php
        }
        ?>
    </ul>
</nav><!-- /navigation-transactions -->
