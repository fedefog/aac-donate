<?php
if(basename($_SERVER['PHP_SELF']) =='transactions-all.php') {
	die('call direct error');
}
?>
<script type="text/javascript">
    jQuery(document).ready(function () {

        //jQuery('#export_csv').attr("href", "<?php echo $url . $param; ?>");
        //jQuery('#export_xls').attr("href", "<?php echo $url1 . $param; ?>");
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
<?php

$tl = $transactionlist->ListItems();

//echo $transactionlist->lastSQL;

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
            <!-- AACDESING -->
            <tr>
                <th>DATE</th>
                <th>DESCRIPTION</th>
                <th>AMOUNT</th>
                <th class="hidden-xs">COMMENTS</th>
                <th class="hidden-xs">TYPE</th>
                <th class="hidden-xs">ACTION</th>
            </tr>
            <!-- END AACDESING -->
        </thead>						
        <tbody>
            <?php
            if ($tl) {

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
                    //if ($i >= ($k - 10) && $i < $k) {
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
                            <!-- AACDESING -->
                            <td class="modal-show comments-td hidden-xs" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                                <a href="javascript:void(0);">
                                        <?php /* echo showBalance($balanceAmt); */?>
                                        <p>Comments goes here from the user to the Charity..</p>
                                </a>
                            </td>
                            <td class="type-td transaction-type-label modal-show" data-toggle="modal" data-target="<?php echo $modal_name; ?>">
                                <p class="type-transactions"><?php echo $type; ?></p>
                                <?php /* <p class="type-transactions"><?php echo getTransactionType($rows1[$i]['cd_no']); ?></p> */ ?>
                            </td>
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
                              <!-- END AACDESING -->
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

			echo UI::makePageNav('transactions.php',$page,$transactionlist->PageCount(),false,$_GET,$pageNavOptions);
			?>
        </li></ul>
    </nav><!-- /navigation-transactions -->
    <?php
}
?>
