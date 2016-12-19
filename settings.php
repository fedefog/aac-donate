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
/**
if ($_REQUEST['doAction']) {
    $qry = "";
    $qry .= " UPDATE users ";
    $qry .= " SET ShowUserDisplayName = '" . $_REQUEST['my-checkbox'] . "'";
    $qry .= ",AutomaticLogin = '" . $_REQUEST['my-checkbox1'] . "'";
    $qry .= ",Sms_enabled = '" . $_REQUEST['my-checkbox2'] . "'";
    $qry .= ",DefaultUserAccount = '" . $_REQUEST['cmbDefUsrAcc'] . "'";
    $qry .= ",Mobile = '" . $_REQUEST['txtPhone'] . "'";
    if ($_REQUEST['txtNewPwd'] != "") {
        $qry .= ",Password = '" . $_REQUEST['txtNewPwd'] . "'";
    }
    $qry .= " Where Username = '" . $user->Username . "'";
    //echo $qry;
    $result = mysql_query($qry);
    if ($result) {
        UI::Redirect('index.php');
    }
}
**/

//AutomaticLogin

$user_data = User::getUserData($user->id);

/*$qry = "";
$qry .= "SELECT * FROM users ";
$qry .= "WHERE Username = " . $user->Username;
$result = mysql_query($qry);
$row = mysql_fetch_row($result, 1);*/
//$fields[Beneficiary] = $_REQUEST['Beneficiary'];
?>
<script type="text/javascript">
    $(document).ready(function(){
		$('.lkn-save').click(function(e){
			e.preventDefault();
	
	
			var formData = $('#editor').serialize();

            $('#editor input').removeClass('has-error-box');
	
	
			$.ajax({
				url: 'remote.php?m=save-settings',
				type: 'post',
				dataType: 'json',
				data: formData,
				success: function(data)
				{
					if(!data.error) {
			            jQuery("#modal-quick-donation p").html("Settings saved.");
						
						loadpage('settings.php');

						//$('.password-box').val('');

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
					}
	    	        jQuery("#modal-quick-donation").modal('show');
				}
			});		

	    });		

    });
</script>

<script type="text/javascript">
/**
    function Validate(form)
    {
        var dispusrnm = $('#my-checkbox').val();
        var autologin = $('#my-checkbox1').val();
        var smsenl = $('#my-checkbox2').val();
        var phone = $('#txtPhone').val();
        var oldpwd = $('#txtOldPwd').val();
        var newpwd = $('#txtNewPwd').val();
        var cfmpwd = $('#txtCfmPwd').val();

        if (oldpwd == "" && (newpwd != "" || cfmpwd != "")) {
            jQuery("#modal-quick-donation p").html('Please enter Old password');
            jQuery("#modal-quick-donation").modal('show');
            return false;
        }

        if (newpwd == "" && cfmpwd != "") {
            jQuery("#modal-quick-donation p").html('Please enter New password');
            jQuery("#modal-quick-donation").modal('show');
            return false;
        }

        if (cfmpwd == "" && newpwd != "") {
            jQuery("#modal-quick-donation p").html('Please enter Confirm password');
            jQuery("#modal-quick-donation").modal('show');
            return false;
        }

        if (newpwd !== cfmpwd) {
            jQuery("#modal-quick-donation p").html('Your New password and Confirm password not match');
            jQuery("#modal-quick-donation").modal('show');
            return false;
        }
        return true;
    }
**/
</script>
<main class="main-transactions main-settings content-desktop">
    <form name="editor" id="editor" method="POST" action="<?php echo basename($_SERVER['PHP_SELF']) ?>">
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
                                <h2 class="title">Settings</h2>
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
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-12 hidden-xs">
                    <div class="header-desktop">
                        <h2 class="title-desktop">Settings</h2>
                    </div>
                </div><!-- / -->
                <div class="col-xs-12 col-md-6">
                    <div class="container-settings">
                        <div class="box-settings">
                            <div class="box-settings-info">
                                <h2 class="title-settings">DISPLAY MY NAME </h2>
                                <p class="info-settings">By enabling this option your name will be displayed in various pages.</p>
                            </div><!-- /box-settings-info -->
                            <input type="checkbox" class="switch-settings" id="my-checkbox" value="1" id="my-checkbox" name="fields[ShowUserDisplayName]" <?php if ($user_data['ShowUserDisplayName'] == "1") echo "checked"; ?>>
                        </div><!-- /box-settings -->
                    </div><!-- /container-settings -->
                    <div class="container-settings">
                        <div class="box-settings">
                            <div class="box-settings-info">
                                <h2 class="title-settings">AUTOMATIC LOGIN </h2>
                                <p class="info-settings">By enabling this option you will not have to enter your username and password to login.</p>
                            </div><!-- /box-settings-info -->
                            <input type="checkbox" class="switch-settings" id="checkbox-automatic-login" value="1" id="my-checkbox1" name="fields[AutomaticLogin]" <?php if ($user_data['AutomaticLogin'] == "1") echo "checked"; ?>>
                        </div><!-- /box-settings -->
                        <div class="default-login" style="display: <?php if ($user_data['AutomaticLogin'] == "1") echo "block"; ?>;">
							<?php /**
                            <div class="box-settings">								
                                <div class="box-settings-info">
                                    <h2 class="title-settings">DEFAULT LOGIN ACCOUNT </h2>
                                    <select id="cmbDefUsrAcc" name="cmbDefUsrAcc" class="form-control selectpicker">
                                        <option>ACCOUNT A9895</option>
                                        <option>ACCOUNT A9895</option>
                                        <option>ACCOUNT A9895</option>
                                        <option>ACCOUNT A9895</option>
                                        <option>ACCOUNT A9895</option>
                                    </select>
                                </div><!-- /box-settings-info -->
                            </div><!-- /box-settings -->
							**/
							?>
                        </div><!-- /default-login -->
                    </div><!-- /container-settings -->
                    <div class="container-settings">
                        <div class="box-settings">
                            <div class="box-settings-info">
                                <h2 class="title-settings">ENABLE SMS SETTINGS </h2>
                                <p class="info-settings">AAC can send you alert text messages. </p>
                            </div><!-- /box-settings-info -->
                            <input type="checkbox" class="switch-settings" id="chebox-sms" id="my-checkbox2" name="fields[Sms_enabled]" value="1" <?php if ($user_data['Sms_enabled'] == "1") echo "checked"; ?> >
                        </div><!-- /box-settings -->
                        <div class="container-settings-msj" style="display: <?php if ($user_data['Sms_enabled'] == "1") echo "block"; ?>;">
                            <div class="box-settings box-settings-msj">
                                <div class="box-settings-info">
                                    <h2 class="title-settings title-send">Send SMS when </h2>
                                    <p class="info-settings">my account balance is lower than: </p>
                                    <span class="price-settings"> £ <?php echo number_format($user_data['Sms_threshold'],2) ?></span>
                                    <a href="make-a-donation.php"></a>
                                </div><!-- /box-settings-info -->
                                <input type="checkbox" class="switch-settings switch-settings-sms" value="Sms_threshold" id="my-checkbox3" name="my-checkbox3">
                            </div><!-- /box-settings -->
                        <div id="Sms_threshold" style="display:none <?php //if ($user_data['Sms_threshold']) echo "block"; ?>;">
                            <div class="box-settings">								
                                <div class="box-settings-info">
                                    <h2 class="title-settings">New Value </h2>
									<input id="box-Sms_threshold" type="text" name="fields[Sms_threshold]" value="<?php echo $user_data['Sms_threshold'] ?>" class="form-control">
                                </div><!-- /box-settings-info -->
                            </div><!-- /box-settings -->
                        </div><!-- /sms_threshold -->
                            <div class="box-settings box-settings-msj">
                                <div class="box-settings-info">
                                    <h2 class="title-settings title-send">Send SMS when </h2>
                                    <p class="info-settings">I receive an incoming payment more than:</p>
                                    <span class="price-settings"> £ <?php echo number_format($user_data['Sms_going_in'],2) ?> </span>
                                </div><!-- /box-settings-info -->
                                <input type="checkbox" class="switch-settings switch-settings-sms" value="Sms_going_in" id="my-checkbox4" name="my-checkbox4" >
                            </div><!-- /box-settings -->
                        <div id="Sms_going_in" style="display:none <?php //if ($user_data['Sms_going_in']) echo "block"; ?>;">
                            <div class="box-settings">								
                                <div class="box-settings-info">
                                    <h2 class="title-settings">New Value </h2>
									<input id="box-Sms_going_in" type="text" name="fields[Sms_going_in]" value="<?php echo $user_data['Sms_going_in'] ?>" class="form-control">
                                </div><!-- /box-settings-info -->
                            </div><!-- /box-settings -->
                        </div><!-- /sms_going_in -->
                            <div class="box-settings box-settings-msj">
                                <div class="box-settings-info">
                                    <h2 class="title-settings title-send">Send SMS when </h2>
                                    <p class="info-settings">I make an outgoing payment of more than:</p>
                                    <span class="price-settings"> £ <?php echo number_format($user_data['Sms_going_out'],2) ?> </span>
                                </div><!-- /box-settings-info -->
                                <input type="checkbox"  class="switch-settings switch-settings-sms" value="Sms_going_out" name="my-checkbox5" >
                            </div><!-- /box-settings -->
                        <div id="Sms_going_out" style="display:none <?php //if ($user_data['Sms_going_in']) echo "block"; ?>;">
                            <div class="box-settings">								
                                <div class="box-settings-info">
                                    <h2 class="title-settings">New Value </h2>
									<input id="box-Sms_going_out" type="text" name="fields[Sms_going_out]" value="<?php echo $user_data['Sms_going_out'] ?>" class="form-control">
                                </div><!-- /box-settings-info -->
                            </div><!-- /box-settings -->
                        </div><!-- /sms_going_in -->

                            <div class="box-phone-numb-settings">
                                <h2 class="title-settings">MOBILE PHONE NUMBER TO TEXT </h2>
                                <form class="form-phone-number">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">PHONE NUMBER</div>
                                            <input type="text" id="box-Mobile" name="fields[Mobile]" class="form-control phone-number-input" value="<?php echo $user_data['Mobile']; ?>">
                                        </div><!-- /input-group -->
                                    </div><!-- /form-group -->
                                </form>
                            </div>
                        </div><!-- /container-mjs -->
                    </div><!-- /container-settings -->
                </div><!-- /col -->
                <div class="col-xs-12 col-md-6">
                    <div class="container-settings">
                        <a href="#" class="lkn-change-password">
                            <div class="box-settings">
                                <div class="box-settings-info">
                                    <h2 class="title-settings">CHANGE PASSWORD </h2>
                                    <p class="info-settings">Easily update your password.</p>
                                </div><!-- /box-settings-info -->
                            </div><!-- /box-settings -->
                        </a>
                        <div class="container-password-settings">
                            <div class="box-settings-password">
                                <h2 class="title-password-settings">CHANGE PASSWORD </h2>
                                <input id="box-txtOldPwd" name="txtOldPwd" type="password" class="form-control" placeholder="Enter current password">
                                <a href="contact-us.php" class="forgot-password external-lkn">Forgot your password ? - Get in touch with us</a>
                            </div><!-- /box-settings-password -->
                            <div class="box-settings-password">
                                <h2 class="title-password-settings">NEW PASSWORD </h2>
                                <input type="password" id="box-txtNewPwd" name="txtNewPwd" class="form-control" placeholder="Choose new password">
                            </div><!-- /box-settings-password -->
                            <div class="box-settings-password">
                                <h2 class="title-password-settings">VERIFY PASSWORD</h2>
                                <input type="password" id="box-txtCfmPwd" name="txtCfmPwd" class="form-control" placeholder="Confirm new password">
                            </div><!-- /box-settings-password -->
                        </div>
                        <div class="container-lkns visible-xs sticky-to-footer">
                            <a href="#" class="lkn-save transaction_page">Save</a>
                            <a href="dashboard.php" class="lkn-cancel transaction_page">Cancel</a>
                        </div><!-- /container-lkns -->
                    </div><!-- /container-settings -->
                </div><!-- /col -->
                <div class="col-md-12 hidden-xs">
                    <div class="line-bottom-settings"></div>
                </div><!-- / -->
                <div class="col-md-12 hidden-xs">
                    <div class="container-lkns">
                        <a href="#" class="lkn-save transition">Save</a>
                        <input type="hidden" name="fields[Request]" value="<?php echo $fields['Request']; ?>"/>
                        <input type="hidden" name="doAction" value="save" />
                        <a href="#" class="lkn-cancel transition">Cancel</a>
                    </div><!-- /container-lkns -->
                </div>
            </div><!-- /row -->
        </div><!-- /container-fluid -->
    </form>
</main>	