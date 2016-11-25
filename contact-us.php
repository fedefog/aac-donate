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
?>
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
        <div class="container-contact-us">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12 hidden-xs">
                        <div class="header-desktop">
                            <h2 class="title-desktop">Contact us</h2>
                        </div><!-- header-desktop -->
                    </div><!-- /col -->
                    <form id="myform" method="post" action="<?php echo basename($_SERVER['PHP_SELF']) ?>">
                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                            <?php if ($_REQUEST['error']) { ?>
                                <p class="red-text">Error</p>
                            <?php } ?>
                            <textarea cols="30" rows="10" id='OfficeComments' name="txtMessage" class="contact-us-textarea" placeholder="How can we help?"></textarea>
                            <!--                            <a href="#" class="contact-send transition hidden-xs">Send Message</a>-->
                            <a href="#" onclick="document.getElementById('myform').submit();" class="send-msj transition">Send Message</a>
                            <div class="box-details-bank">
                                <h2 class="title-bank-details">BANK DETAILS</h2>
                                <p class="text">ACHISOMOCH AID CO. LTD.</p>
                                <p class="text">SORT CODE 20-29-37</p>
                                <p class="text">ACCOUNT NO 2033 2003</p>
                            </div><!-- / -->
                            <div class="hidden-xs box-for-answers">
                                <h2 class="title-footer">FOR ANSWERS TO COMMONLY ASKED QUESTIONS</h2>
                                <a href="help.php" class="subtitle-footer transition external-lkn">PLEASE VIEW OUR FAQs</a>
                            </div>
                        </div><!-- /col -->
                        <input type="hidden" name="doAction" value="save" />
                    </form>
                </div><!-- /row -->
            </div><!-- /container -->
        </div><!-- /container-contact-us -->
        <a href="#" class="sticky-to-footer visible-xs">
            <h2 class="title-footer">FOR ANSWERS TO COMMONLY ASKED QUESTIONS</h2>
            <p  class="subtitle-footer">PLEASE VIEW OUR FAQs</p>
        </a>	
    </main>
    <?php
}
?>