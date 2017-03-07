<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
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

AjaxCheck();

$user = new User();
$user = User::GetInstance();
$fields['Request'] = "General Message";
if ($_POST['doAction']) {
    $from = $user->Email;
    $to = EMAIL_ADMIN_CONTACT;
    $subject = 'Achisomoch - members page';
    $message = $_REQUEST['txtMessage'];
    /* echo "From:" . $from . "<br>";
      echo "To:" . $to . "<br>";
      echo "Subject:" . $subject . "<br>";
      echo "Message:" . $message . "<br>"; */
    if (mail($to, $subject, $message, "From:{$from}\r\n")) {
        UI::Redirect('index.php');
    }
}

            $user = User::GetInstance();
            $balance = number_format($user->Close_balance, 2);
            $account = $user->Username;
            $date = date('d M Y, H:iA', strtotime($user->Close_balance_date));

if($_REQUEST['id']) {
    $id = $_REQUEST['id'];
    $item = new AACRequestItem();
    if($item->load($id)) {
        $fields[OfficeComments] = $item->OfficeComments;
    } else die('Unable to locate entry');
}

?>
<script type="text/javascript">
    $(document).ready(function(){

        $('.read-more').click(function(e){
            e.preventDefault();

            var id = $(this).attr('data-value');

            $.ajax({
                url: 'remote.php?m=contact-message-view&id='+id,
                type: 'post',
                dataType: 'html',
                data: null,
                success: function(html)
                {

                     jQuery("#contact-message-view-modal .modal-body").html(html);
                     jQuery("#contact-message-view-modal").modal('show');
                        
                }
            });     
    

        });


        $('#send-contact').click(function(e){
            e.preventDefault();
    
            if (jQuery('#txtComment').val() == "") {
                jQuery("#modal-quick-donation p").html("Please enter comments.");
                jQuery("#modal-quick-donation").modal('show');
                return false;
            }
            //jQuery('#myform').submit();
    
            var formData = $('#myform').serialize();
    
    
            $.ajax({
                url: 'remote.php?m=contact',
                type: 'post',
                dataType: 'json',
                data: formData,
                success: function(data)
                {
                    if(!data.error) {
                        jQuery("#modal-quick-donation p").html(
                            '<h2>Thank You.</h2>'+
                            '<p>Your message has been sent</p>'+
                            '<p>We will be in touch shortly</p>'
                        );
                        jQuery("#modal-quick-donation").modal('show');

                        //$('#myform input, #myform textarea').val('');
                        loadpage('contact-us.php');

                        //AACDESIGN3
                        //loadpage('dashboard.php');

                        //$('body').addClass('has-notification');
                        //$('.notification-box font').html('Thank you for contacting us');
                        //$('.notification-box').show();

                    } else {

                        jQuery("#modal-quick-donation p").html(data.errorMessage);
                        $('#box-'+data.errorField).addClass('has-error-box');
                        $('#box-'+data.errorField).focus();

                        var pos = null;
                        if(data.errorField) pos = $('#box-'+data.errorField).offset();
                        if(pos) {
                            var top = pos.top - 220;
                            var left = pos.left - 20;
                            window.scrollTo((left < 0 ? 0 : left), (top < 0 ? 0 : top));
                        }
                        jQuery("#modal-quick-donation").modal('show');

                        //jQuery("#modal-quick-donation p").html("An error has occured - please contact support.");
                        //jQuery("#modal-quick-donation").modal('show');
                    }

                }
            });     

        });     

    });
</script>


<?php if ($_REQUEST['done']) { ?>
    <p class="blue-text">Your request has been sent.
        <a href="index.php" class="subtitle-footer transition external-lkn">
            Return to Home Page.
        </a>
    </p>
    <div style="height:150px"></div>
<?php } else { ?>
    <main class="main-transactions main-contact-us content-desktop">
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
                                <h2 class="title">Contact us</h2>
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
        <div class="container visible-xs top-center-content">
            <div class="row">
                    <div class="col-xs-12">

                        <div class="box-account-header visible-xs">

                            <div class="box-account">

                                <h2 class="title">ACCOUNT</h2> 

                                <h3 class="account-number"><?php echo $account; ?></h3>

                            </div><!-- /box-account -->

                            <div class="box-balance">

                                <h2 class="title">BALANCE</h2>

                                <h3 class="balance-number">£ <?php echo $balance; ?></h3>

                            </div><!-- /box-balance -->

                        </div><!-- /box-account-header -->

                        <h3 class="time-update visible-xs">AS OF <strong><?php echo $date; ?></strong></h3>

                    </div><!-- / col 12 -->
            </div><!-- / row -->
        </div><!-- / top center content -->
        <div class="container-contact-us">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 hidden-xs">
                        <div class="header-desktop">
                            <h2 class="title-desktop">Contact us</h2>
                        </div><!-- header-desktop -->
                    </div><!-- /col -->
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                        <div class="send-message-container">
                            <span class="title">Send a Message</span>
                            <form id="myform" method="post" action="<?php echo basename($_SERVER['PHP_SELF']) ?>">
                                <?php if ($_REQUEST['error']) { ?>
                                    <p class="red-text">Error</p>
                                <?php } ?>
                                <textarea cols="30" rows="10" id='OfficeComments' name="fields[OfficeComments]" class="contact-us-textarea" placeholder="How can we help?"><?php echo $fields[OfficeComments] ?></textarea>
                                <!--                            <a href="#" class="contact-send transition hidden-xs">Send Message</a>-->
                                <!-- AACDESIGN3 -->
                                <a href="#" id="send-contact" class="send-msj transition" >Send Message</a>
                                <div class="box-details-bank">
                                    <h2 class="title-bank-details">BANK DETAILS</h2>
                                    <p class="text">ACHISOMOCH AID CO. LTD.</p>
                                    <p class="text">SORT CODE 20-29-37</p>
                                    <p class="text">ACCOUNT NO 2033 2003</p>
                                    <a href="" data-toggle="modal" data-target="#modal-success">Modal Test</a>
                                </div><!-- / -->
                                <input type="hidden" name="doAction" value="save" />
                            </form>
                        </div>
                    </div><!-- /col -->

                    <!-- AACDESIGN3 -->
                    <div class="col-xs-12 col-md-6">
                        <div class="messages-container">
                             <span class="title">Previous Messages</span>
                            <div class="messages-box">
                                <?php
                                $user = new User();
                                $user = User::GetInstance();

                                $transactionlist = new AACRequestList();
    
                                $transactionlist->filters[] = 'UserName="' . $user->Username . '" ';
                                $transactionlist->filters[] = 'Request IN ("General Message")  ';

                                $cList = $transactionlist->ListItems();
                                if(count($cList)) {
                                    foreach($cList as $ci) {
                                    //data-target="#message-modal" data-toggle="modal"
                                    ?>
                                    <div class="message">
                                        <span class="date"><?php echo date('d-m-y',$ci->RequestDateTime) ?></span> <?php echo substr($ci->OfficeComments,0,60) ?> <a href="#" class="read-more" data-value="<?php echo $ci->id ?>">Read More</a>
                                    </div>
                                    <?php
                                    }
                                } else {
                                ?>
                                <div class="no-message">
                                    <span>You have not sent any message yet</span>
                                </div>
                                <?php } ?>


                            </div>
                        </div> <!-- END AACDESIGN3 -->
                    </div> 
                </div><!-- /row -->

                <div class="row">
                    <div class="hidden-xs box-for-answers">
                        <h2 class="title-footer">FOR ANSWERS TO COMMONLY ASKED QUESTIONS</h2>
                        <a href="help.php" class="subtitle-footer transition external-lkn">PLEASE VIEW OUR FAQs</a>
                    </div>
                </div><!-- Row -->

            </div><!-- /container -->
        </div><!-- /container-contact-us -->    
    </main>

    <!-- AACDESIGN3 -->
    <?php include 'inc/contact-message-view-modal.php' ?>
    <?php include 'inc/success-modal.php' ?>
    <?php //include 'inc/contact-us-confirm-modal.php' ?>
    <?php
}
?>