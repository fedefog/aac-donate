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
					<a href="index.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img src="images/dashboard-icon.png"  height="23">
						</span>
						<span class="text">Dashboard </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="transactions.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img src="images/view-transactions-icon.png" width="18" height="23">
						</span>
						<span class="text">View Transactions </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="make-a-donation.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img src="images/make-donation-icon.png" width="24" height="25">
						</span>
						<span class="text">Make a Donation </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="standing-orders.php" class="lkn-dashboard dif-bg">
						<span class="icon">
							<img src="images/standing-orders-icon.png" width="18" height="30.5">
						</span>
						<span class="text">Standing orders </span>
						<i class="fa fa-angle-right" aria-hidden="true">
						</i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="vouchers.php" class="lkn-dashboard">
						<span class="icon">
							<img src="images/order-voucher-icon.png" width="22" height="21">
						</span>
						<span class="text">Order Vouchers Books</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="help.php" class="lkn-dashboard">
						<span class="icon">
							<img src="images/help-icon.png" width="20.5" height="20">
						</span>
						<span class="text">Help</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="contact-us.php" class="lkn-dashboard">
						<span class="icon">
							<img src="images/contact-icon.png" width="24" height="20.5">
						</span>
						<span class="text">Contact Us</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="invite-a-friend.php" class="lkn-dashboard">
						<span class="icon">
							<img src="images/invite-a-friend-icon.png" width="20.5" height="20">
						</span>
						<span class="text">Invite a Friend</span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="#" class="lkn-logout" data-toggle="modal" data-target="#modal-logout">

						<span class="icon">
							<i class="fa fa-sign-out" aria-hidden="true"></i>
						</span>

						<span class="text">Logout</span>

					</a>
				</li>
			</ul>
		
		</div><!-- /col -->
	
	</div><!-- /row -->
	
</div><!-- /container-fluid -->
	

<? include 'inc/footer.php' ?>