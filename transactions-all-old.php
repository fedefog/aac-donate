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
    foreach ($search_array as $array) {
        if ($array[1] == "LIKE") {
            $sql .= " AND " . $array[0] . " " . $array[1] . " '%" . $array[2] . "%'";
        } else {
            $sql .= " AND " . $array[0] . " " . $array[1] . " '" . $array[2] . "'";
        }
    }
    if ($req_type == "in") {
        $transactionlist = new TransactionList();
        $transactionlist->sortby = 'DateTime';
        $transactionlist->sortorder = 'desc';
        $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '" AND Amount > 0 ' . $sql);
        //$tl = $transactionlist->getInTransactionListSearch($user->id, $search_array);
    } else if ($req_type == "out") {
        $transactionlist = new TransactionList();
        $transactionlist->sortby = 'DateTime';
        $transactionlist->sortorder = 'desc';
        $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '" AND Amount < 0 ' . $sql);
        //$tl = $transactionlist->getOutTransactionListSearch($user->id, $search_array);
    } else {
        $transactionlist = new TransactionList();
        $transactionlist->sortby = 'DateTime';
        $transactionlist->sortorder = 'desc';
        $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '" ' . $sql);
        //$tl = $transactionlist->getTransactionListSearch($user->id, $search_array);
    }
} else {
    if ($req_type == "in") {
        $transactionlist = new TransactionList();
        $transactionlist->sortby = 'DateTime';
        $transactionlist->sortorder = 'desc';
        $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '" AND Amount > 0');
        //$tl = $transactionlist->getInTransactionListByUserName($user->id);
    } else if ($req_type == "out") {
        $transactionlist = new TransactionList();
        $transactionlist->sortby = 'DateTime';
        $transactionlist->sortorder = 'desc';
        $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '" AND Amount < 0');
        //$tl = $transactionlist->getOutTransactionListByUserName($user->id);
    } else {
        if ($_REQUEST['startdate'] && $_REQUEST['enddate']) {
            $transactionlist = new TransactionList();
            $transactionlist->sortby = 'DateTime';
            $transactionlist->sortorder = 'desc';
            $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . " AND DateTime BETWEEN '" . date('Y-m-d', strtotime('-18 months')) . "' AND '" . date('Y-m-d', time()) . '"');
            //$tl = $transactionlist->getTransactionListByUserName($user->id, "0");
        } else {
            $transactionlist = new TransactionList();
            $transactionlist->sortby = 'DateTime';
            $transactionlist->sortorder = 'desc';
            $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '"');
            //$tl = $transactionlist->getTransactionListByUserName($user->id, "1");
        }
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
    $parameter1 .= '&&sort=' . $sort . '&&fieldname=' . $fieldname;

    foreach ($search_array as $array) {
        if ($array[1] == "LIKE") {
            $sql .= " AND " . $array[0] . " " . $array[1] . " '%" . $array[2] . "%'";
        } else {
            $sql .= " AND " . $array[0] . " " . $array[1] . " '" . $array[2] . "'";
        }
    }

    $transactionlist->sortby = $fieldname;
    $transactionlist->sortorder = $sort;
    $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '" ' . $sql);
    //$tl = $transactionlist->getTransactionListBySorting(intval($user->id), $search_array, $fieldname, $sort);

    /* if ($sort == 'SORT_ASC') {
      $rows1 = array_orderby($rows1, $fieldname, SORT_ASC);
      } else {
      $rows1 = array_orderby($rows1, $fieldname, SORT_DESC);
      } */
}
if ($_REQUEST['startdate'] && $_REQUEST['enddate']) {
    $parameter1 .= '&&startdate=' . $_REQUEST['startdate'] . '&&enddate=' . $_REQUEST['enddate'];
    $startdate = date_create_from_format('d-m-Y', $_REQUEST['startdate'])->format('Y-m-d');
    $enddate = date_create_from_format('d-m-Y', $_REQUEST['enddate'])->format('Y-m-d');
    $startdate = strtotime($startdate);
    $enddate = strtotime($enddate);
    $rowdate = array();
    $j = 0;
    $i = 0;
    foreach ($tl as $t) {
        //$dt = date_create_from_format('j-n-y', $rows1[$i]['datetime'])->format('Y-m-d');
        //$strtime = strtotime($dt);
        $strtime = strtotime($t->DateTime);
        if (($strtime >= $startdate) && ($strtime <= $enddate)) {
            $rows1[$j]['amount'] = $t->Amount;
            $rows1[$j]['datetime'] = date('j-n-y', strtotime($t->DateTime));
            $rows1[$j]['cd_no'] = $t->CDNo;
            $rows1[$j]['name'] = $t->Name;
            $rows1[$j]['voucher'] = $t->Voucher;
            $rowdate[$j] = $i;
            $j++;
        }
        $i++;
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
if ($_REQUEST['startdate'] && $_REQUEST['enddate']) {
    $param .= '&&startdate=' . $_REQUEST['startdate'] . '&&enddate=' . $_REQUEST['enddate'];
}
if ($_REQUEST['sort'] && $_REQUEST['fieldname']) {
    $param .= '&&sort=' . $_REQUEST['sort'] . '&&fieldname=' . $_REQUEST['fieldname'];
}
?>
        jQuery('#export_csv').attr("href", "<?php echo $url . $param; ?>");
        jQuery('#export_xls').attr("href", "<?php echo $url1 . $param; ?>");
        jQuery(document).on('click', '.transaction_all-row', function () {
            var modal_data = jQuery(this).data('id');
            var modal_type = jQuery(this).data('type');
            var row_arr = modal_data.split('||');
            if (modal_type == "VO" || modal_type == "NV" || modal_type == "PEN") {
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
<input type="hidden" name="parameter1" id="parameter1" value="<?php echo $parameter1; ?>">
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
    <table class="table-transactions table table-condensed">
        <thead class="hidden-xs "> 
            <tr>
                <th>DATE</th>
                <th>DESCRIPTION</th>
                <th>AMOUNT</th>
                <th class="hidden-xs">BALANCE AFTER TRANSACTION</th>
                <th class="hidden-xs">TYPE</th>
                <?php /* <th class="hidden-xs">ACTION</th> */ ?>
            </tr>
        </thead>						
        <tbody>
            <?php
            if ($tl) {
                //$cnt = 0;
                $k = $page * 10;
                $i = ($page - 1) * 10;
                $i = 0;
                if (isset($n)) {
                    $j = $n;
                } else {
                    $j = count($tl);
                }
                if ($k > $j) {
                    $k = $j;
                }
                $m = 0;
                foreach ($tl as $t) {
                    if ($m < $i) {
                        $rowBal += $t->Amount;
                        $m++;
                    }
                }
                foreach ($tl as $t) {
                    $data = "";
                    $status = "";

                    if ($t->CDNo == "PEN") {
                        //$status = "Currently being processed";
                        $status = "Pending";
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

                    $type = $t->description;

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
                        $status = 'online request';
                    }
                    if ($i >= ($k - 10) && $i < $k) {
                        ?>
                        <tr class="<?php echo getBalanceColor(number_format($t->Amount, 2)); ?> transaction_all-row" data-id="<?php echo $data; ?>" data-type="<?php echo $t->CDNo; ?>">
                            <?php /* <tr class="<?php echo $balance_color; ?> modal-show transaction_all-row" data-toggle="modal" data-target="<?php echo $modal_name; ?>" data-id="<?php echo $data; ?>" data-type="<?php echo $rows1[$i]['cd_no']; ?>"> */ ?>
                            <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                                <a href="javascript:void(0);">
                                    <div class="date"><?php echo date('j-n-y', strtotime($t->DateTime)); ?></div>
                                </a>
                            </td>
                            <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                                <a href="javascript:void(0);">
                                    <div class="desc-table">
                                        <h2 class="title">
                                            <?php
                                            /**
                                              if($rows1[$i]['charity_number'] != "" && $rows1[$i]['charity_number'] != 0){
                                              echo $rows1[$i]['name'];
                                              }
                                             * */
                                            echo $t->Description;
                                            ?>
                                        </h2>
                                        <h3 class="subtitle transaction-type-label"><?php echo $status; ?></h3>
                                    </div><!-- /desc-table -->
                                </a>
                            </td>
                            <td class="modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                                <a href="javascript:void(0);">
                                    <span class="balance-transition voucher-balance">
                                        <?php echo showBalance($t->Amount); ?>
                                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </td>
                            <td class="modal-show amount-td hidden-xs" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                                <a href="javascript:void(0);">
                                    <span class="balance-transition">
                                        <?php echo showBalance($balanceAmt); ?>
                                    </span>
                                </a>
                            </td>
                            <td class="type-td transaction-type-label modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                                <p class="type-transactions"><?php echo $type; ?></p>
                                <?php /* <p class="type-transactions"><?php echo getTransactionType($rows1[$i]['cd_no']); ?></p> */ ?>
                            </td>
                            <?php /*
                              <td class="action-edit hidden-xs">
                              <?php
                              //$rows1[$i]['cd_no'] = "SO";
                              //$rows1[$i]['request_id'] = "8176";
                              if ($t->CDNo == "SO" && $t->RequestId > 0) {
                              ?>
                              <!--<a href="make-a-donation.php?id=<?php //echo $rows1[$i]['request_id']; ?>&clone=1" class="refresh-transactions btn-trannsaction-accion external-lkn"></a>-->
                              <a href="make-a-donation.php?id=<?php echo $t->RequestId; ?>" class="edit-transactions btn-trannsaction-accion external-lkn"></a>
                              <a href="javascript:void(0);" class="delete-transactions btn-trannsaction-accion" data-id="<?php echo $id; ?>" onClick="cancelStandingOrder('<?php echo $t->RequestId; ?>');"></a>
                              <?php
                              } else {
                              if ($t->RequestId && $t->RequestId > 0) {
                              ?>
                              <a href="make-a-donation.php?id=<?php echo $t->RequestId; ?>&clone=1" class="refresh-transactions btn-trannsaction-accion external-lkn"></a>
                              <?php
                              }
                              }
                              ?>
                              </td>
                             */ ?>
                    <input type="hidden" name="vchnumber" class="vch-number" value="<?php echo $t->Voucher; ?>">
                    </tr>
                    <?php
                }
                $i++;
            }
            //$cnt = $k - 1;
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
    <?php
}
?>
