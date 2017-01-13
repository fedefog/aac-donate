<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'cls/charities.cls.php';
	require_once 'cls/ui.cls.php';
	require_once 'inc/funcs.inc.php';
require_once 'cls/vouchers.cls.php';


session_start();

User::LoginCheck();

$user = new User();
$user = User::GetInstance();

if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

if(!$type) $type = $_REQUEST['type']?$_REQUEST['type']:'current';

$somList = new StandingOrderMasterList();
$somList->filters[] = 'Account="' . intval($user->Username) . '" ';

if($type=='current') {
	$somList->filters[] = ' active=\'Y\' ';
	$param = "&type=current";
} else {
	$somList->filters[] = ' active=\'N\'   ';
	$param = "&type=previous";
}

$somList->SetPage($page);

$somItems = $somList->ListItems();




/**
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
**/
//echo 'count:'.count($t);
//print_r($data);
/**
if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
**/
?>
<script type="text/javascript">
    jQuery(document).ready(function () {

<?php
$url = "PHPExcel_1.8.0_doc/export_excel_standing.php?filename=csv";
$url1 = "PHPExcel_1.8.0_doc/export_excel_standing.php?filename=xls";

?>
        jQuery('#export_csv_so').attr("href", "<?php echo $url . $param; ?>");
        jQuery('#export_xls_so').attr("href", "<?php echo $url1 . $param; ?>");
/**
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
**/

    });
</script>
<?php
if (!count($somItems)) {
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
<!-- AACDESING -->
    
<table class="table-transactions table-standing-orders table table-condensed">
    <thead class="hidden-xs "> 
        <tr>
            <th>ID</th>
            <th>CHARITY</th>
            <th>END DATE</th>
            <th>AMOUNT</th>            
            <th class="hidden-xs">INTERVAL</th>
            <th class="hidden-xs">CURRENT SO TO BE PAID</th>
            <th class="hidden-xs"></th>
            <th class="hidden-xs">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($somItems)) {
            $k = $page * 10;
            $i = ($page - 1) * 10;
            $i = 0;
            $j = count($t);

            if ($k > $j) {
                $k = $j;
            }

            foreach ($somItems as $t) {
                //if ($t->StandingOrderEndDate >= time() || $t->StandingOrderEndDate == "" || $t->StandingOrderEndDate == "0") {
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


				$data = $t->id;

                    ?>

        <tr class="balance-up">
            <td class="hidden-xs td-center standing-orders" data-id="<?= $data; ?>" data-type="SOM" data-toggle="modal" data-target="#modal-voucher">
                <?php echo $id; ?>
            </td>
            <td class="standing-orders" data-id="<?= $data; ?>" data-type="SOM" data-toggle="modal" data-target="#modal-voucher">
                 <a href="javascript:void(0);">
                    <div class="desc-table">
                        <h2 class="title td-center"><?php echo $name; ?></h2>
                        <h3 class="subtitle visible-xs">EVERY  <?php echo strtoupper($interval); ?></h3>
                    </div><!-- /desc-table -->
                </a>
            </td>
            <td class="hidden-xs td-interval standing-orders" data-id="<?= $data; ?>" data-type="SOM" data-toggle="modal" data-target="#modal-voucher">
                <span class="date-interval"><?php echo $t->end_date !='0000-00-00'?strtoupper(date('M Y',strtotime($t->end_date))):'' ?></span>
            </td>
            <td class="standing-orders" data-id="<?= $data; ?>" data-type="SOM" data-toggle="modal" data-target="#modal-voucher">
                <a href="#">
                    <span class="balance-transition ">
                        <?php echo showBalance($amt); ?>
                        <!--£ -->
                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </span>
                </a>
            </td>
            <td class="hidden-xs td-interval">
                <span class="date-interval">EVERY <?php echo strtoupper($interval); ?></span>
            </td>
            <td class="hidden-xs td-end-date">
                <span class="to-be-paid"><?php echo showBalance($t->total_amount_paid); ?></span>
            </td>
            <td class="hidden-xs td-view-transaction">
                <a href="standing-orders-transactions.php?id=<?php echo $id; ?>" class="external-lkn lkn-view-transaction">VIEW TRANSACTIONS</a>
            </td>
            <td class="action-edit hidden-xs">
				<?php if($type=='current') { ?>
                <a href="make-a-donation.php?SOMID=<?php echo $id; ?>" class="edit-transactions btn-trannsaction-accion external-lkn"></a>
                <a href="javascript:void(0);" class="delete-transactions btn-trannsaction-accion" data-id="<?php echo $id; ?>" onClick="cancelStandingOrder('<?php echo $id; ?>','<?php echo $name; ?>');"></a>
				<?php } else { ?>
                <a href="make-a-donation.php?SOMID=<?php echo $id; ?>&repeat=1" class="refresh-transactions btn-trannsaction-accion external-lkn"></a>
				<?php } ?>
            </td>
        </tr>
                    <?php
            }
        }
        ?>                                        
    </tbody>

</table>    

<!-- END AACDESING -->


    <nav class="navigation-transactions hidden-xs" aria-label="Page navigation  ">
        <ul class="pagination nav-transactions"><li>
            <?php

			$pageNavOptions  = array(
				'NoItemsText'=>'',
				'MaxVisiblePageNums'=>5,
				'PrevPageText'=>'&laquo;',
				'NextPageText'=>'&raquo;',
				'FirstPageText'=>'',
				'LastPageText'=>'',
				'ShowAllText'=>'',
				'ShowAllAlign'=>'',
				'LeadingText'=>'',
				'SuffixText'=>'',
				'PageNumSeperator'=>'</li><li>',
				'UseJavascriptFunction'=>'',
			);

			echo UI::makePageNav('standing-orders.php',$page,$somList->PageCount(),false,$_GET,$pageNavOptions);
			?>
        </li></ul>
    </nav><!-- /navigation-transactions -->