<?
$section = 'dashboard';
include 'inc/header.php'
?>

<div id="main-container">

	<? include 'dashboard.php' ?>

</div><!-- / main container -->

<div class="container-fluid content-nav-desktop hidden-xs">

	<div class="row">
	
		<div class="col-xs-12">
		   
		    <div class="box-daily-updates visible-xs">
			    	
				<a href="#" class="lkn-daily daily-dashboard"> 
					<span class="date">SEP-14 </span>  ROSH HASHANAH UPDATE 
					<i class="fa fa-angle-down" aria-hidden="true"></i>
					<i class="fa fa-angle-up" aria-hidden="true"></i>
				</a>

				<p class="text">The office will be closed Monday September 21 to Thursday the 24th. Please ensure all transactions are dealt with as soon as possible to avoid any issues given the high demand. Wishing everyone a ksiva v'chasima tova.</p>

		    </div><!-- /box-daily-updates -->

			<ul class="nav-dashboard">
				
				<li class="dashboard-li">
					<a href="dashboard.php" class="lkn-dashboard dif-bg current-page">
						<span class="icon">
							<img class="default" src="images/dashboard-icon.png"  height="23">
							<img class="active" src="images/dashboard-icon-active.png"  height="23">
						</span>
						<span class="text">Dashboard </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="transactions.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img class="default" src="images/view-transactions-icon.png" width="20.5" height="28">
							<img class="active" src="images/view-transactions-icon-active.png" width="20.5" height="28">
						</span>
						<span class="text">View Transactions </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="make-a-donation.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img class="default" src="images/make-donation-icon.png" width="23" height="27">
							<img class="active" src="images/make-donation-icon-active.png" width="23" height="27">
						</span>
						<span class="text">Make a Donation </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="standing-orders.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img class="default" src="images/standing-orders-icon.png" width="18" height="30.5">
							<img class="active" src="images/standing-orders-icon-active.png" width="18" height="30.5">
						</span>
						<span class="text">Standing orders </span>
						<i class="fa fa-angle-right" aria-hidden="true">
						</i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="vouchers.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img class="default" src="images/order-voucher-icon.png" width="22" height="21">
							<img class="active" src="images/order-voucher-icon-active.png" width="22" height="21">
						</span>
						<span class="text">Order Vouchers Books</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="help.php" class="lkn-dashboard">
						<span class="icon">
							<img class="default" src="images/help-icon.png" width="20.5" height="20">
							<img class="active" src="images/help-icon-active.png" width="20.5" height="20">
						</span>
						<span class="text">Help</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="contact-us.php" class="lkn-dashboard">
						<span class="icon">
							<img class="default" src="images/contact-icon.png" width="24" height="20.5">
							<img class="active" src="images/contact-icon-active.png" width="24" height="20.5">
						</span>
						<span class="text">Contact Us</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="invite-a-friend.php" class="lkn-dashboard">
						<span class="icon">
							<img class="default" src="images/invite-a-friend-icon.png" width="20.5" height="20">
							<img class="active" src="images/invite-a-friend-icon-active.png" width="20.5" height="20">
						</span>
						<span class="text">Invite a Friend</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<a href="#" class="lkn-logout" data-toggle="modal" data-target="#modal-logout">

					<span class="icon">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
					</span>

					<span class="text">Logout</span>

				</a>
			</ul>
		
		</div><!-- /col -->
	
	</div><!-- /row -->
	
</div><!-- /container-fluid -->
	

<? include 'inc/modal-order-has-been-saved.php' ?>
<? include 'inc/online-donation-modal.php' ?>
<? include 'inc/give-as-you-earn-modal.php' ?>
<? include 'inc/giftaid-rebate-modal.php' ?>
<? include 'inc/comision-modal.php' ?>
<? include 'inc/voucher-book-modal.php' ?>
<? include 'inc/voucher-modal.php' ?>
<? include 'inc/standing-order-donation.php' ?>
<? include 'inc/company-donation-modal.php' ?>
<? include 'inc/charity-donation-modal.php' ?>
<? include 'inc/account-transfer-modal.php' ?>
<? include 'inc/footer.php' ?>