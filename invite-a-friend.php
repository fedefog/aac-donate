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
    $to = $_REQUEST['txtEmail'];
    $subject = 'Achisomoch - Invite Friend';
    $message = $_REQUEST['txtComment'];

    /*echo "From:" . $from . "<br>";
    echo "To:" . $to . "<br>";
    echo "Message:" . $message . "<br>";
    exit;*/

    if (mail($to, $subject, $message, "From:{$from}\r\n")) {
        UI::Redirect('index.php');
    }
}
?>
<script type="text/javascript">
    function sendInvitation() {
        if (jQuery('#txtName').val() == "") {
            jQuery("#modal-quick-donation p").html("Please enter your friend's name.");
            jQuery("#modal-quick-donation").modal('show');
            return false;
        }
        if (jQuery('#txtEmail').val() == "") {
            jQuery("#modal-quick-donation p").html("Please enter your friend's email.");
            jQuery("#modal-quick-donation").modal('show');
            return false;
        }
        if (jQuery('#txtComment').val() == "") {
            jQuery("#modal-quick-donation p").html("Please enter comments.");
            jQuery("#modal-quick-donation").modal('show');
            return false;
        }
        jQuery('#myform').submit();
    }
</script>
<main class="main-transactions main-invite-a-friend content-desktop">

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

                            <h2 class="title">Invite a friend</h2>

                        </div><!-- /col -->	

                        <div class="col-xs-3">

                            <a href="#" class="nav-mobile nav-icon4 visible-xs ">

                                <span></span>
                                <span></span>
                                <span></span>

                            </a>

                        </div><!-- /col -->	

                    </div><!-- /header-mobile-transactions -->

                </div><!-- /row  -->	

            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->

    <div class="box-invite-header">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 col-xs-12 hidden-xs">

                    <div class="header-desktop">
                        <h2 class="title-desktop">Invite a Friend</h2>
                    </div><!-- header-desktop -->

                </div><!-- /col -->				

                <div class="col-md-12">

                    <h2 class="title-box">REFER A FRIEND TO AAC</h2>

                    <p class="desc-box">Once they use their new account to donate their first £2,000, <strong> you'll receive £100 credit</strong> into your account.</p>

                    <p class="desc-box">Enter their name and email address and they'll receive a single email from us that passes on your recommendation.</p>
                </div><!-- /col -->

            </div><!-- /row -->

        </div><!-- /container -->

        <div class="container-msj-ok">

            <div class="msj-ok">

                <div class="container-fluid">

                    <div class="title-msj-ok">Thankyou for the recommendation.</div>

                    <p class="desc-msj-ok"> Is there anyone else you'd like to recommend AAC to?</p>

                </div><!-- /container-fluid -->

            </div><!-- /msj-ok -->

        </div><!-- /container-msj -->

    </div><!-- /box-invite-header -->

    <div class="container-fluid container-border-desktop hidden-xs">
        <div class="col-md-12">
            <div class="border-bottom "></div>
        </div><!-- /col -->
    </div><!-- /container -->

    <form class="invite-friend" id="myform" method="post" action="<?php echo basename($_SERVER['PHP_SELF']) ?>">

        <div class="container-fluid">

            <div class="row">

                <div class="col-xs-12 col-md-6">

                    <div class="form-group">

                        <label for="" class="label">FRIEND’S NAME</label>

                        <input type="text" class="form-control input-text" id="txtName" name="txtName" placeholder="Enter your friend’s name" >

                    </div><!-- /form-group -->

                    <div class="form-group">

                        <label for="" class="label">FRIEND’S EMAIL ADDRESS</label>

                        <input type="text" class="form-control input-text " id="txtEmail" name="txtEmail" placeholder="Enter your friend’s email address" >

                    </div><!-- /form-group -->

                </div><!-- /col -->

                <div class="col-xs-12 col-md-6">

                    <div class="form-group">

                        <label for="" class="label">COMMENTS</label>

                        <textarea cols="30" rows="10" class="comment-textarea " id="txtComment" name="txtComment" placeholder="Enter any text that you'd like to pass on"></textarea>

                    </div><!-- /form-group -->

                </div><!-- /col -->

                <div class="col-xs-12 col-md-12">
                    <a href="#" onclick="sendInvitation();" class="send-invite transition">Send Invite</a>
                </div>
                <input type="hidden" name="doAction" value="save" />
            </div><!-- /row -->

        </div><!-- /container-fluid -->

    </form>

</main>	