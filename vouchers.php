<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'inc/funcs.inc.php';
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

$request = new AACRequestItem();


if ($_REQUEST['Request']) {
    $fields['Request'] = $_REQUEST['Request'];
} else {
    $fields = $_REQUEST;
    $fields['Request'] = "New Voucher Book";
}


if (isset($_POST['submit1'])) {
    $fields = $_POST['fields'];
    $fields['Request'] = "New Voucher Book";


    $error = '';

    switch ($fields['Request']) {
        case 'New Voucher Book':
            $vbCount = 0;

            if (count($fields['VoucherBooks'])) {
                foreach ($fields['VoucherBooks'] as $qty)
                    $vbCount+=$qty;
            }
            if (!$vbCount)
                $error = 'Please specify a quantity for voucher books';
            else if (!$fields['VoucherBookDelivery'])
                $error = 'Please select a delivery method';

            if (($vbCount > 2) && ($fields['VoucherBookDelivery'] == 'Post'))
                $error = 'Post is not available for more than 2 voucher books';
            break;
    }

    //print_r($fields);

    if (!$error) {
        $request->Username = $user->Username;
        if (!$id) {
            $request->ResultCode = 'Pending';
            $request->RequestDateTime = time();
        }
//var_dump($fields['VoucherBooks']);

        if ($fields['VoucherBooks'] && is_array($fields['VoucherBooks']) && count($fields['VoucherBooks'])) {
            $vb = '';
            foreach ($fields['VoucherBooks'] as $vbook => $qty) {
                if (!$qty)
                    continue;
                $vbook = utf8_decode(html_entity_decode($vbook));
                $vb .= "{$qty}x{$vbook}; ";
            }
            //$fields['VoucherBooks'] = implode("\r\n",$fields['VoucherBooks']);
            $fields['VoucherBooks'] = trim($vb, ' ;');
        }


        /* if ($fields['VoucherBookDelivery'] && is_array($fields['VoucherBookDelivery']) && count($fields['VoucherBookDelivery'])) {
          $vbdelivery = '';
          foreach ($fields['VoucherBookDelivery'] as $vbd => $d) {
          if (!$d)
          continue;
          $vbd = utf8_decode(html_entity_decode($vbd));
          $vbdelivery .= "{$d}x{$vbd}; ";
          }
          $fields['VoucherBookDelivery'] = trim($vbdelivery, ' ;');
          }
          echo $fields['VoucherBookDelivery'];
          //exit; */
        //$fields['StandingOrderStartDate'] = $fields['StandingOrderStartDate']?strtotime('01-'.$fields['StandingOrderStartDate'])+3600:'0';
        $fields['StandingOrderStartDate'] = $fields['StandingOrderStartDate'] ? strtotime($fields['StandingOrderStartDate']) + 3600 : '0';

        $fields['StandingOrderEndDate'] = $fields['StandingOrderEndDate'] ? intval($fields['StandingOrderEndDate']) + 3600 : '0';

        $fields['System'] = 'Desktop';
        $request->SetProperties($fields);
        $request->UpdateSummary();
        $request->VoucherBookUrgent = $request->VoucherBookUrgent ? 'Yes' : 'No';

        $request->Save();
        UI::Redirect('index.php');
        //$emails = new AchisomochEmails();
        //$emails->SendRequestConfirmations($user, $request);

        $details = "Request: " . $fields['Request'];
        if ($_POST['clone'])
            $details .= ' : Re-Request';
        User::LogAccessRequest($user->Username, '', $details);


        UI::Redirect('?done=true');
    }
} else if (!$_REQUEST['done'] && !$id) {
    $details = "New Request: " . $fields['Request'];
    User::LogAccessRequest($user->Username, '', $details);
}

switch ($fields['Request']) {
    case 'New Voucher Book':
        $field_list = array('VoucherBookField');
        break;
    default:
        die('Unknown request');
        $field_list = array();
}
?>

<script type="text/javascript">

    jQuery(document).ready(function () {

        jQuery('.lkn-order-vouchers').on('click', function () {

            if (jQuery('.bootstrap-switch').hasClass('bootstrap-switch-on') == true) {
                //alert('Now you are ready to submit.');
                jQuery('#editor').submit();
                document.getElementById('editor').submit();
            } else {
                jQuery("#modal-quick-donation p").html('Please select a delivery method');
                jQuery("#modal-quick-donation").modal('show');
            }

            /*var active = jQuery('.label-delivery').parent().hasClass('active');
             if (active) {
             alert('Now you are ready to submit.');
             //document.getElementById('editor').submit();
             } else {
             jQuery("#modal-quick-donation p").html('Please select a delivery method');
             jQuery("#modal-quick-donation").modal('show');
             }*/
        });
    });

    jQuery('#delivery_type_post').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state == true) {
            jQuery("#delivery_type_office").bootstrapSwitch('state', false);
            jQuery("#delivery_type_special").bootstrapSwitch('state', false);
            jQuery("#VoucherBookDelivery").val('');
            jQuery("#VoucherBookDelivery").val(jQuery(this).data('value'));
        }
    });
    jQuery('#delivery_type_office').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state == true) {
            jQuery("#delivery_type_post").bootstrapSwitch('state', false);
            jQuery("#delivery_type_special").bootstrapSwitch('state', false);
            jQuery("#VoucherBookDelivery").val('');
            jQuery("#VoucherBookDelivery").val(jQuery(this).data('value'));
        }
    });
    jQuery('#delivery_type_special').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state == true) {
            jQuery("#delivery_type_post").bootstrapSwitch('state', false);
            jQuery("#delivery_type_office").bootstrapSwitch('state', false);
            jQuery("#VoucherBookDelivery").val('');
            jQuery("#VoucherBookDelivery").val(jQuery(this).data('value'));
        }
    });
    /*jQuery(".bootstrap-switch").on('click', function () {
     alert('ok');
     jQuery(".bootstrap-switch").each(function () {
     if (!jQuery('.bootstrap-switch').hasClass('bootstrap-switch-on') && jQuery(this)) {
     jQuery('.bootstrap-switch').removeClass('bootstrap-switch-on');
     }
     });
     });*/

    function updateVoucherBooks() {

        var total = 0;

        jQuery('.VoucherBooks').each(function () {
//console.log($(this).val());

            var intRegex = /^\d+$/;

            if (intRegex.test($(this).val())) {
                total += parseInt($(this).val());
            }
        });
        if (total > 2) {
            jQuery('#post').addClass('disable');
            jQuery('.row-input').removeClass('active');
        } else {
            jQuery('#post').removeClass('disable');
        }
    }
<?php if (time() < mktime(0, 0, 0, 3, 18, 2015)) { ?>

        jQuery('#delivery_type_post').on('switchChange.bootstrapSwitch', function (event, state) {
            if (state == true) {
                jQuery("#modal-quick-donation p").html('Please note that until  Purim there is a ' + "\u00a3" + '2 delivery charge');
                jQuery("#modal-quick-donation").modal('show');
            }
        });

        /*jQuery('.checkbox-input').click(function () {
         if (jQuery(this).data("value") == 'Post') {
         //alert('Please note that until  Purim there is a ' + "\u00a3" + '2 delivery charge');
         jQuery("#modal-quick-donation p").html('Please note that until  Purim there is a ' + "\u00a3" + '2 delivery charge');
         jQuery("#modal-quick-donation").modal('show');
         }
         });*/
<?php } ?>
</script>

<?php if ($_REQUEST['done']) { ?>
    <p class="blue-text" style="margin: 0 15%;">Your request has been sent. <a href="index.php">Return to request Main Page.</a></p>
    <div style="height:150px"></div>
<?php } else { ?>	
    <main class="main-transactions order-voucher content-desktop">

        <div class="header-fixed visible-xs">

            <header class="header ">

                <div class="container ">

                    <div class="row">

                        <div class="header-mobile-transactions">

                            <div class="col-xs-2">

                                <a href="dashboard.php" class="go-back">

                                    <i class="fa fa-angle-left" aria-hidden="true"></i>

                                </a>

                            </div><!-- /col -->

                            <div class="col-xs-8">

                                <h2 class="title">Order Vouchers Books</h2>

                            </div><!-- /col -->	

                            <div class="col-xs-2">

                                <a href="#" class="nav-mobile nav-icon4 visible-xs ">

                                    <span></span>
                                    <span></span>
                                    <span></span>

                                </a>

                            </div><!-- /col -->	

                        </div><!-- /header-mobile-transactions -->

                        <div class="clear"></div>

                    </div><!-- /row  -->	

                </div><!-- /container  -->

            </header>

        </div><!-- /header-fixed -->

        <div class="container top-center-content visible-xs">

            <div class="row">

                <div class="col-xs-12">

                    <div class="box-account-header visible-xs">

                        <div class="box-account">

                            <h2 class="title">ACCOUNT</h2> 

                            <h3 class="account-number">A7895</h3>

                        </div><!-- /box-account -->

                        <div class="box-balance">

                            <h2 class="title">BALANCE</h2>

                            <h3 class="balance-number">£ 3,344.99</h3>

                        </div><!-- /box-balance -->

                    </div><!-- /box-account-header -->

                    <h3 class="time-update visible-xs">AS OF <strong>1 SEP 2016, 2:15PM</strong></h3>

                </div><!-- / col 12 -->

            </div><!-- / row -->

        </div><!-- / top center content -->
        <div class="box-slide-text">
            <div class="container-fluid">
                <?php
                /* $qry = "";
                  $qry .= "select * from notes";
                  $result = mysql_query($qry);
                  $row_notes = mysql_fetch_row($result); */
                $transactionlist = new TransactionList();
                $notes_row = $transactionlist->getNotes();
                ?>
                <a href="javascript:void(0);" class="lkn-daily">
                    <p class="text"><?php echo substr(trim($notes_row[0]->TopTickerMessage), 0, 140); ?></p>
                    <!--<i class="fa fa-angle-down" aria-hidden="true"></i>
                    <i class="fa fa-angle-up" aria-hidden="true"></i>-->
                </a>
            </div><!-- container -->

        </div><!-- /box-daily-updates -->

        <div class="row hidden-xs">
            <div class="col-md-12">
                <h2 class="title-section-desktop">Order Vouchers Books</h2>
            </div>
        </div>
        <form name="editor" id="editor" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="container-vochers">

                <div class="container-fluid">

                    <div class="row">
                        <div >
                            <div class="col-md-6 col-xs-12">

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][50p]" class="input-number VoucherBooks"  value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PREPAID 50P VOUCHERS</div>

                                        <div class="subtitle-label">100 VOUCHERS</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£1]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PREPAID £1 VOUCHER </div>

                                        <div class="subtitle-label">50 VOUCHERS</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£3]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PRE-PRINTED £3</div>

                                        <div class="subtitle-label">VOUCHER BOOK</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£5]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PRE-PRINTED £5</div>

                                        <div class="subtitle-label">VOUCHER BOOK</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£10]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PRE-PRINTED £10</div>

                                        <div class="subtitle-label">VOUCHER BOOK</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->

                            </div><!-- /col -->

                            <div class="col-md-6 col-xs-12">

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£18]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PRE-PRINTED £18</div>

                                        <div class="subtitle-label">VOUCHER BOOK</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£25]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PRE-PRINTED £25</div>

                                        <div class="subtitle-label">VOUCHER BOOK</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->

                                <div class="form-group input-default">

                                    <div class="input-group ">

                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£50]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>

                                    </div><!-- /input-group -->

                                    <div class="info-input">

                                        <div class="title-label">PRE-PRINTED £50</div>

                                        <div class="subtitle-label">VOUCHER BOOK</div>

                                    </div><!-- /info-input -->

                                </div><!-- /form-group -->
                                <div class="form-group input-default">
                                    <div class="input-group ">
                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][£100]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>
                                    </div><!-- /input-group -->
                                    <div class="info-input">
                                        <div class="title-label">PRE-PRINTED £100</div>
                                        <div class="subtitle-label">VOUCHER BOOK</div>
                                    </div><!-- /info-input -->
                                </div><!-- /form-group -->
                                <div class="form-group input-default">
                                    <div class="input-group ">
                                        <a href="#" class="less-input lkn-input"></a>
                                        <input type="text" name="fields[VoucherBooks][Blank]" class="input-number VoucherBooks" value="0">
                                        <a href="#" class="more-input lkn-input"></a>
                                    </div><!-- /input-group -->
                                    <div class="info-input">
                                        <div class="title-label">BLANK</div>
                                        <div class="subtitle-label">VOUCHER BOOK</div>
                                    </div><!-- /info-input -->
                                </div><!-- /form-group -->
                            </div><!-- /col-->
                        </div>
                    </div><!-- /row -->
                </div><!-- /container- -->
                <div class="container-fluid container-border-desktop hidden-xs">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border-bottom "></div>
                        </div><!-- /col -->
                    </div><!-- /row -->
                </div><!-- /container -->
            </div><!-- /container-vochers -->
            <div class="container-delivery">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-delivery">
                                <div class="form-group">
                                    <h2 class="title-delivery">DELIVERY </h2>
                                    <div class="container-urgent hidden-xs">
                                        <input type="checkbox" class="switch-settings" data-value="post" id="delivery_type_post" name="fields[VoucherBookDelivery][post]">
                                        <div class="label-delivery">
                                            <div class="label-urgent">POST: UP TO TWO BOOKS
                                                <div class="subtitle-label">I TAKE RESPONSIBILITY FOR ANY 50P/£1 PPV BOOKS LOST IN THE POST</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container-urgent hidden-xs">
                                        <input type="checkbox" class="switch-settings" data-value="Pick up from office" id="delivery_type_office" name="fields[VoucherBookDelivery][office]">
                                        <div class="label-delivery">
                                            <div class="label-urgent">OFFICE COLLECTION 
                                                <div class="subtitle-label">9.30AM - 3.30PM MON-THURS</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container-urgent hidden-xs">
                                        <input type="checkbox" class="switch-settings" data-value="Special Delivery" id="delivery_type_special" name="fields[VoucherBookDelivery][special]">
                                        <div class="label-delivery">
                                            <div class="label-urgent">SPECIAL DELIVERY 
                                                <div class="subtitle-label">AT A COST OF £5 TO BE DEDUCTED FROM MY ACCOUNT</div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /form-group -->
                            </div>
                        </div><!-- /col -->
                        <div class="col-md-6">
                            <div class="container-urgent hidden-xs">
                                <input type="checkbox" class="switch-settings" id="my-checkbox" name="fields[VoucherBookUrgent]">
                                <h2 class="label-urgent">THIS IS URGENT</h2>
                            </div><!-- /container-urgent -->
                            <div class="container-notes hidden-xs">
                                <label class="title-notes">NOTES TO AAC</label>
                                <textarea id="OfficeComments" name="fields[OfficeComments]" cols="30" rows="10" class="textarea-notes" placeholder="Add any notes you'd wish to pass on to AAC."></textarea>	
                            </div><!-- /container-urgent -->					
                        </div><!-- /col -->
                    </div><!-- /row -->
                </div><!-- /container -->
                <div class="container-fluid container-border-desktop hidden-xs">
                    <div class="col-md-12">
                        <div class="border-bottom "></div>
                    </div><!-- /col -->
                </div><!-- /container -->

            </div><!-- /container-delivery -->
            <input type="hidden" name="submit1" value="save" />
            <input type="hidden" name="fields[VoucherBookDelivery]" id="VoucherBookDelivery">
        </form>

        <div class="col-md-12 hidden-xs">

            <a href="#" class="lkn-order-vouchers transition disabled">Order Vouchers</a>

        </div><!-- /col -->

        <div class="container-urgent visible-xs">

            <div class="container-fluid">

                <input type="checkbox" id="my-checkbox" name="my-checkbox">

                <h2 class="label-urgent">THIS IS URGENT</h2>

            </div><!-- /container -->

        </div><!-- /container-urgent -->

        <div class="container-notes visible-xs">

            <div class="container-fluid">

                <label class="title-notes">NOTES TO AAC</label>

                <textarea cols="30" rows="10" class="textarea-notes" placeholder="Add any notes you'd wish to pass on to AAC."></textarea>	

            </div><!-- /container -->

        </div><!-- /container-urgent -->

        <a href="#" class="sticky-to-footer lkn-order-vouchers visible-xs disabled">Order Vouchers</a>

    </main>	
<?php }
?>
