<?
$section = 'dashboard';
include 'inc/header.php'
?>

<div id="main-container">
	
	<main id="dashboard">
		<h1>desktop</h1>
		<div class="header-fixed visible-xs" >

	        <header class="header ">

	            <div class="container ">
				
					<div class="row">

						<a href="transactions-pending.php" title="Pending Transactions" class="pending-bt">
							<img src="images/pending-icon.png" width="21" height="21">
							<span class="badge">2</span>
						</a>
						
						<div class="col-md-4">
								
							<h1 class="logo-header">
								
								<a href="#">
									
									<img src="images/logo-aac.svg" alt="">

								</a>

							</h1>
						
						</div><!-- /col -->

						<div class="col-md-4">
						
							<h2 class="title-welcome">Welcome to your account.</h2>

							<div class="box-account-header">
								
								<div class="box-account">
									
									<h2 class="title">ACCOUNT</h2> 
									
									<h3 class="account-number">A7895</h3>
									
								</div><!-- /box-account -->

								<div class="box-balance">
									
									<h2 class="title">BALANCE</h2>

									<h3 class="balance-number">£ 3,344.99</h3>

								</div><!-- /box-balance -->

							</div><!-- /box-account-header -->

							<h3 class="time">AS OF <strong>1 SEP 2016, 2:15PM</strong></h3>

						</div><!-- /col -->	

						<a href="#" class="nav-mobile nav-icon4 visible-xs ">
		                                
		                    <span></span>
		                    <span></span>
		                    <span></span>

		                </a>
					
					</div><!-- /row  -->	
	            
	            </div><!-- /container  -->

	        </header>

	    </div><!-- /header-fixed -->


	    <div class="container-fluid content-nav-mobile visible-xs ">
		
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
							<a href="transactions.php" class="lkn-dashboard">
								<span class="icon">
									<img src="images/view-transactions-icon.png" width="18" height="23">
								</span>
								<span class="text">View Transactions </span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</a>
						</li>
						<li class="dashboard-li">
							<a href="make-a-donation.php" class="lkn-dashboard">
								<span class="icon">
									<img src="images/make-donation-icon.png" width="23" height="27">
								</span>
								<span class="text">Make a Donation </span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</a>
						</li>
						<li class="dashboard-li">
							<a href="standing-orders.php" class="lkn-dashboard">
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
									<img src="images/order-voucher-icon.png" width="24.5" height="20.5">
								</span>
								<span class="text">Order Vouchers Books</span>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							</a>
						</li>
					</ul>
				
				</div><!-- /col -->
			
			</div><!-- /row -->
			
		</div><!-- /container-fluid -->


		<? include 'inc/footer-inner.php' ?>

	</main>	


	<div id="new-content">

	</div>

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
					<a href="index.php" class="lkn-dashboard">
						<span class="icon">
							<img src="images/dashboard-icon.png"  height="23">
						</span>
						<span class="text">Dashboard </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="transactions.php" class="lkn-dashboard">
						<span class="icon">
							<img src="images/view-transactions-icon.png" width="18" height="23">
						</span>
						<span class="text">View Transactions </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="make-a-donation.php" class="lkn-dashboard">
						<span class="icon">
							<img src="images/make-donation-icon.png" width="24" height="25">
						</span>
						<span class="text">Make a Donation </span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</li>
				<li class="dashboard-li">
					<a href="standing-orders.php" class="lkn-dashboard">
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
			</ul>
		
		</div><!-- /col -->
	
	</div><!-- /row -->
	
</div><!-- /container-fluid -->
	

<? include 'inc/footer.php' ?>