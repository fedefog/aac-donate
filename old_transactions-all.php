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
//$record = $user->GetXMLRecord();
$req_type = $_REQUEST['type'];
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
$parameter1 = 'page=' . $page;
if ($_REQUEST['field'] && $_REQUEST['search']) {
    $search = $_REQUEST['search'];
    $field = $_REQUEST['field'];
} else {
    $search_array = array();
    if ($_REQUEST['transaction_id']) {
        $search = $_REQUEST['transaction_id'];
        $field = 't.id';
        $parameter1 .='&&field=' . $field . '&&search=' . $search;
        $search_array[] = array($field, '=', $search);
    } if ($_REQUEST['charity_name']) {
        $search = $_REQUEST['charity_name'];
        $field = 'c.Name';
        $parameter1 .='&&field=' . $field . '&&search=' . $search;
        $search_array[] = array($field, 'LIKE', $search);
    } if ($_REQUEST['amount_donated']) {
        $search = $_REQUEST['amount_donated'];
        $field = 't.Amount';
        $parameter1 .='&&field=' . $field . '&&search=' . $search;
        //$search_array[] = array($field, '<=', $search);
        $search_array[] = array($field, '=', $search);
    } if ($_REQUEST['personal_note']) {
        $search = $_REQUEST['personal_note'];
        $field = 'a.UserComments';
        $parameter1 .='&&field=' . $field . '&&search=' . $search;
        $search_array[] = array($field, 'LIKE', $search);
    } if ($_REQUEST['voucher_no']) {
        $search = $_REQUEST['voucher_no'];
        $field = 't.Voucher';
        $parameter1 .='&&field=' . $field . '&&search=' . $search;
        $search_array[] = array($field, '=', $search);
    } if ($_REQUEST['book_voucher_no']) {
        $search = $_REQUEST['book_voucher_no'];
        $field = 't.Voucher';
        $parameter1 .='&&field=' . $field . '&&search=' . $search;
        $search_array[] = array($field, '=', $search);
    } if ($_REQUEST['transaction_type']) {
        $search = $_REQUEST['transaction_type'];
        $field = 't.CDNo';
        $parameter1 .='&&field=' . $field . '&&search=' . $search;
        $search_array[] = array($field, '=', $search);
    }
    //print_r($search_array);
}

//echo 'param:'.$parameter1;

/* if ($search && $field) {
  $parameter1 .='&&field=' . $field . '&&search=' . $search;
  } */
$transactionlist = new TransactionList();
if (($_REQUEST['result'] && $search) || ($search_array)) {
    if ($req_type == "in") {
        echo 'in';
        $tl = $transactionlist->getInTransactionListSearch($user->id, $search_array);
    } else if ($req_type == "out") {
        echo 'out';
        $tl = $transactionlist->getOutTransactionListSearch($user->id, $search_array);
    } else {
        $tl = $transactionlist->getTransactionListSearch($user->id, $search_array);
        //$tl = $transactionlist->getTransactionListSearch($user->id, $search, $field);
    }
    for ($i = 0; $i < count($tl); $i++) {
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
    }
} else {
    if ($req_type == "in") {
        $tl = $transactionlist->getInTransactionListByUserName($user->id);
    } else if ($req_type == "out") {
        $tl = $transactionlist->getOutTransactionListByUserName($user->id);
    } else {
        if ($_REQUEST['startdate'] && $_REQUEST['enddate']) {
            $tl = $transactionlist->getTransactionListByUserName($user->id, "0");
        } else {
            $tl = $transactionlist->getTransactionListByUserName($user->id, "1");
        }
    }
    for ($i = 0; $i < count($tl); $i++) {
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
        $rows1[$i]['status'] = $tl[$i]->status;
        $rows1[$i]['request_datetime'] = $tl[$i]->RequestDateTime;
        $rows1[$i]['client_comments'] = $tl[$i]->ClientComments;
        $rows1[$i]['office_comments'] = $tl[$i]->OfficeComments;
        $rows1[$i]['standingorder_enddate'] = $tl[$i]->StandingOrderEndDate;
        $rows1[$i]['payment_number'] = $tl[$i]->PaymentNumber;
        $rows1[$i]['description'] = $tl[$i]->description;
    }
}

function array_orderby() {
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row) {
                $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

if ($_REQUEST['sort'] && $_REQUEST['fieldname']) {
    $sort = $_REQUEST['sort'];
    $fieldname = $_REQUEST['fieldname'];
    $parameter1 .='&&sort=' . $sort . '&&fieldname=' . $fieldname;
    //echo 'param:'.$parameter1;
    if ($sort == 'SORT_ASC')
        $rows1 = array_orderby($rows1, $fieldname, SORT_ASC);
    else
        $rows1 = array_orderby($rows1, $fieldname, SORT_DESC);
}
if ($_REQUEST['startdate'] && $_REQUEST['enddate']) {
    $parameter1 .= '&&startdate=' . $_REQUEST['startdate'] . '&&enddate=' . $_REQUEST['enddate'];
    //echo '$parameter1'.$parameter1;
    //exit;
    $startdate = date_create_from_format('d-m-Y', $_REQUEST['startdate'])->format('Y-m-d');
    $enddate = date_create_from_format('d-m-Y', $_REQUEST['enddate'])->format('Y-m-d');
    $startdate = strtotime($startdate);
    $enddate = strtotime($enddate);
    $j = 0;
    $rowdate = array();
    for ($i = 0; $i < count($tl); $i++) {
        $dt = date_create_from_format('j-n-y', $rows1[$i]['datetime'])->format('Y-m-d');
        $strtime = strtotime($dt);
        if (($strtime >= $startdate) && ($strtime <= $enddate)) {
            $rows1[$j]['amount'] = $rows1[$i]['amount'];
            $rows1[$j]['datetime'] = $rows1[$i]['datetime'];
            $rows1[$j]['cd_no'] = $rows1[$i]['cd_no'];
            $rows1[$j]['name'] = $rows1[$i]['name'];
            $rows1[$j]['voucher'] = $rows1[$i]['voucher'];
            $rowdate[$j] = $i;
            $j++;
        }
    }
    $n = count($rowdate);
}
//echo 'param:'.$parameter1;
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
<?php
$url = "PHPExcel_1.8.0_doc/export_excel.php?filename=csv";
$url1 = "PHPExcel_1.8.0_doc/export_excel.php?filename=xls";
$param = "";
if ($_REQUEST['field'] && $_REQUEST['search']) {
    $param = $param . "&search=" . $_REQUEST['search'];
    $param = $param . "&field=" . $_REQUEST['field'];
} else {
    if ($_REQUEST['transaction_id']) {
        $param = $param . "&transaction_id=" . $_REQUEST['transaction_id'];
    } else if ($_REQUEST['charity_name']) {
        $param = $param . "&charity_name=" . $_REQUEST['charity_name'];
    } else if ($_REQUEST['amount_donated']) {
        $param = $param . "&amount_donated=" . $_REQUEST['amount_donated'];
    } else if ($_REQUEST['personal_note']) {
        $param = $param . "&personal_note=" . $_REQUEST['personal_note'];
    } else if ($_REQUEST['voucher_no']) {
        $param = $param . "&voucher_no=" . $_REQUEST['voucher_no'];
    } else if ($_REQUEST['book_voucher_no']) {
        $param = $param . "&book_voucher_no=" . $_REQUEST['book_voucher_no'];
    } else if ($_REQUEST['transaction_type']) {
        $param = $param . "&transaction_type=" . $_REQUEST['transaction_type'];
    }
}
?>
        jQuery('#export_csv').attr("href", "<?php echo $url . $param; ?>");
        jQuery('#export_xls').attr("href", "<?php echo $url1 . $param; ?>");
        jQuery(document).on('click', '.transaction_all-row', function () {
            var modal_data = jQuery(this).data('id');
            var modal_type = jQuery(this).data('type');
            var row_arr = modal_data.split('||');
            if (modal_type == "VO" || modal_type == "NV"  || modal_type == "PEN") {
                jQuery('#vo_mdl_beneficiary').html();
                jQuery('#vo_mdl_beneficiary').html(row_arr[1]);
                jQuery('#vo_mdl_dnt_amt').html();
                jQuery('#vo_mdl_dnt_amt').html(row_arr[3]);
                jQuery('#vo_mdl_dt_prcd').html();
                jQuery('#vo_mdl_dt_prcd').html(row_arr[2]);
                jQuery('#vo_mdl_vch_num').html();
                jQuery('#vo_mdl_vch_num').html(row_arr[4]);
                jQuery("#lnk_vch_donate_again").attr('href', 'make-a-donation.php?charity_id=' + row_arr[8]);
            } else if (modal_type == "SO") {
                jQuery('#modal_beneficiary').html();
                jQuery('#modal_beneficiary').html(row_arr[1]);
                jQuery('#modal_date_paid').html();
                jQuery('#modal_date_paid').html(row_arr[2]);
                jQuery('#modal_amount').html();
                jQuery('#modal_amount').html(row_arr[3]);
                jQuery('#modal_payments_number').html();
                jQuery('#modal_payments_number').html(row_arr[5]);
                jQuery('#modal_notes_aac').html();
                if (row_arr[6] == "") {
                    jQuery('#modal_notes_aac').html("No Notes have been added");
                } else {
                    jQuery('#modal_notes_aac').html(row_arr[6]);
                }
                jQuery('#modal_charity_notes').html();
                if (row_arr[7] == "") {
                    jQuery('#modal_charity_notes').html("No Notes have been added");
                } else {
                    jQuery('#modal_charity_notes').html(row_arr[7]);
                }
                jQuery("#lnk_view_all").attr('href', 'standing-orders.php?charity_id=' + row_arr[8]);
            } else if (modal_type == "Cd" || modal_type == "Ch") {
                jQuery('#mdl_comp_name').html();
                jQuery('#mdl_comp_name').html(row_arr[1]);
                jQuery('#mdl_amount').html();
                jQuery('#mdl_amount').html(row_arr[3]);
                jQuery('#mdl_date').html();
                jQuery('#mdl_date').html(row_arr[2]);
                jQuery("#lnk_donate_again").attr('href', 'make-a-donation.php?charity_id=' + row_arr[8]);
            }
        });
    });
</script>
<input type="hidden" name="parameter1" id="parameter1" value="<?php echo $parameter1; ?>">
<table class="table-transactions table table-condensed">
    <thead class="hidden-xs "> 
        <tr>
            <th>DATE</th>
            <th>DESCRIPTION</th>
            <th>AMOUNT</th>
            <th class="hidden-xs">BALANCE AFTER TRANSACTION</th>
            <th class="hidden-xs">TYPE</th>
			<!--
            <th class="hidden-xs">ACTION</th>
			-->
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
                $rowBal += $rows1[$m]['amount'];
            }
//var_dump($rowBal);
            for ($i; $i < $k; $i++) {
                $data = "";
                $status = "";

				$type = $rows1[$i]['description'];

				/**
                if ($rows1[$i]['status'] == "0") {
                    //$status = "Currently being processed";
                    $status = "Pending";
                }
				**/
                if ($rows1[$i]['cd_no'] == "PEN") {
                    //$status = "Currently being processed";
                    $status = "Pending";
					$type = 'PENDING';
                }
//var_dump($rows1[$i]['amount']);

                $balanceAmt = $rowBal;
                if (in_array($rows1[$i]['cd_no'],array("VO","PEN","NV"))) {
                    $modal_name = "#modal-voucher";
                } else if ($rows1[$i]['cd_no'] == "SO") {
                    $modal_name = "#modal-standing-order-donation";
                } else if ($rows1[$i]['cd_no'] == "Cd" || $rows1[$i]['cd_no'] == "Ch") {
                    $modal_name = "#modal-company-donation";
                } else {
                    $modal_name = "";
                }
                    
                $type = $rows1[$i]['description'];

                $data .= $rows1[$i]['id'] . "||";
                $data .= $rows1[$i]['name'] . "||";
                $data .= date_create_from_format('j-n-y', $rows1[$i]['datetime'])->format('j-n-Y') . "||";
                $data .= showBalance(abs($rows1[$i]['amount'])) . "||";
                $data .= $rows1[$i]['voucher'] . "||";
                $data .= $rows1[$i]['StandingOrderType'] . ' ' . $rows1[$i]['NumberOfPayments'] . "||";
                $data .= $rows1[$i]['client_comments'] . "||";
                $data .= $rows1[$i]['office_comments'] . "||";
                $data .= $rows1[$i]['charity_number'] . "||";

				if($rows1[$i]['voucher'] && substr($rows1[$i]['voucher'],0,1)=='9') $status = 'online request';

                //$balance_color = getBalanceColor(number_format($rows1[$i]['amount'], 2));
                //$balance_color = str_replace('balance-up', 'balance-down', $balance_color);
                ?>
                <tr class="<?php echo getBalanceColor(number_format($rows1[$i]['amount'], 2)); ?> transaction_all-row" data-id="<?php echo $data; ?>" data-type="<?php echo $rows1[$i]['cd_no']; ?>">
                <?php /* <tr class="<?php echo $balance_color; ?> modal-show transaction_all-row" data-toggle="modal" data-target="<?php echo $modal_name; ?>" data-id="<?php echo $data; ?>" data-type="<?php echo $rows1[$i]['cd_no']; ?>"> */ ?>
                    <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                        <a href="javascript:void(0);">
                            <div class="date"><?php echo $rows1[$i]['datetime']; ?></div>
                        </a>
                    </td>
                    <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                        <a href="javascript:void(0);">
                            <div class="desc-table">
                                <h2 class="title">
                                    <?php
                                    if($rows1[$i]['charity_number'] != "" && $rows1[$i]['charity_number'] != 0){
                                        echo $rows1[$i]['name'];                                
                                    }
                                    ?>
                                </h2>
                                <h3 class="subtitle transaction-type-label"><?php echo $status; ?></h3>
                            </div><!-- /desc-table -->
                        </a>
                    </td>
                    <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                        <a href="javascript:void(0);">
                            <span class="balance-transition voucher-balance">
                                <?php echo showBalance($rows1[$i]['amount']); ?>
                                <i class="fa fa-caret-up" aria-hidden="true"></i>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </span>
                        </a>
                    </td>
                    <td class="modal-show amount-td hidden-xs" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                        <a href="javascript:void(0);">
                            <span class="balance-transition">
                                <!--£ <?php //echo number_format($balanceAmt, 2); ?>-->
                                <?php echo showBalance($balanceAmt); ?>
                            </span>
                        </a>
                    </td>
                    <td class="type-td transaction-type-label modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                        <p class="type-transactions"><?php echo $type ?></p>
                        <?php /* <p class="type-transactions"><?php echo getTransactionType($rows1[$i]['cd_no']); ?></p> */ ?>
                    </td>
				<?php /**
                    <td class="action-edit hidden-xs">
                        <?php
                        //$rows1[$i]['cd_no'] = "SO";
                        //$rows1[$i]['request_id'] = "8230";
                        if ($rows1[$i]['cd_no'] == "SO") {
                            ?>
<!--
                            <a href="make-a-donation.php?id=<?php echo $rows1[$i]['request_id']; ?>&clone=1" class="refresh-transactions btn-trannsaction-accion external-lkn"></a>
-->

                            <a href="make-a-donation.php?id=<?php echo $rows1[$i]['request_id']; ?>&clone=1" class="refresh-transactions btn-trannsaction-accion external-lkn"></a>

                            <a href="make-a-donation.php?id=<?php echo $rows1[$i]['request_id']; ?>" class="edit-transactions btn-trannsaction-accion external-lkn"></a>

                            <a href="javascript:void(0);" class="delete-transactions btn-trannsaction-accion" data-id="<?php echo $id; ?>" onClick="cancelStandingOrder('<?php echo  $rows1[$i]['id']; ?>');"></a>
                            
                            <!--<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
                            <a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>-->
                            <?php
                        } else {
							if($rows1[$i]['request_id']) {
                            ?>
                            <a href="make-a-donation.php?id=<?php echo $rows1[$i]['request_id']; ?>&clone=1" class="refresh-transactions btn-trannsaction-accion external-lkn"></a>
                            <?php
							}
                        }
                        ?>
                    </td>
				<?php **/ ?>
            <input type="hidden" name="vchnumber" class="vch-number" value="<?php echo $rows1[$i]['voucher']; ?>">
            </tr>
            <?php
                $rowBal += $rows1[$i]['amount'];
        }
    } else {
        echo '<tr>';
        echo '<td colspan="5" align="center"><h3>No Result Found.</h3><td>';
        echo '<tr>';
    }
    ?>
    </tbody>
    <input type="hidden" id="current_data" name="current_data" value="<?php print base64_encode(serialize($tl)); ?>">
</table>
<nav class="navigation-transactions hidden-xs" aria-label="Page navigation  ">
    <ul class="pagination nav-transactions">
        <?php
        /* $class = "class='pag-active page external-lkn'";
          $class1 = "class='page external-lkn'"; */
        $class = "class='pag-active page'";
        $class1 = "class='page'";
        $parameter = null;
        if ($sort && $fieldname) {
            $parameter = '&&sort=' . $sort . '&&fieldname=' . $fieldname;
        }
        if ($_REQUEST['startdate'] && $_REQUEST['enddate']) {
            $parameter = '&&startdate=' . $_REQUEST['startdate'] . '&&enddate=' . $_REQUEST['enddate'];
        }
        if ($search && $field) {
            $parameter .='&&field=' . $field . '&&search=' . $search;
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
                    <a href="transactions-all.php?page=<?php
                    echo $page - 1;
                    echo $parameter;
                    ?>" class='page' aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php } ?>
            </li>
            <li><a href="transactions-all.php?page=1<?php echo $parameter; ?>" <?php
                if ($page == 1)
                    echo $class;
                else
                    echo $class1;
                ?> id="page1">1</a></li>
                   <?php
                   for ($i = 2; $i <= $total_page; $i++) {
                       ?>
                <li><a href="transactions-all.php?page=<?php
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
                    <a href="transactions-all.php?page=<?php
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
