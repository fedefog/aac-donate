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
                <!-- AACDESIGN -->
            
               <div class="voucher-books-header">
                    <h2 class="title-section-desktop">Order Vouchers Books</h2>
                    <div class="navigator-voucher-books">
                        <a href="order-voucher-books.php" class="selected">ORDER VOUCHER BOOKS</a>
                        <a href="previous-order-books.php">PREVIOUS ORDERS</a>
                    </div>
                </div> 
                <!-- END AACDESIGN -->
            </div>
        </div>
        
        <div class="row visible-xs">
            <div class="col-md-12">
                <!-- AACDESIGN -->
            
               <div class="voucher-books-header">
                    
                    <div class="navigator-voucher-books">
                        <a href="order-voucher-books.php" class="selected">ORDER VOUCHER BOOKS</a>
                        <a href="previous-order-books.php">PREVIOUS ORDERS</a>
                    </div>
                </div> 
                <!-- END AACDESIGN -->
            </div>
        </div>
        
        <!-- AACDESIGN -->

        <div class="ajax-voucher-books">

            <?php include 'order-voucher-books.php'; ?>
            
        </div><!-- /ajax-voucher-books -->
    </main>	
<?php }
?>
