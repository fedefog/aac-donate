<?
$section = 'dashboard';
include 'inc/header.php'
?>

<div id="main-container">
	
	<main id="dashboard">
		
		<div class="content-desktop-dashboard container-fluid hidden-xs">

			<div class="row">
				
				<div class="col-md-12 top-content">

					<h1>Welcome to your account, David.</h1>
					<div class="date pull-right">FRIDAY 1 SEP 2016, 2:15PM</div>

					<div class="line"></div>

				</div><!-- col 12 -->

			</div>

			<div class="row">
				
				<div class="col-md-6">

					<h2>Latest Transactions</h2>

					<table class="table-transactions table table-condensed">
						<thead> 
							<tr>
								<th>DATE</th>
								<th>DESCRIPTION</th>
								<th>AMOUNT</th>
								<th>TYPE</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-standing-order-donation" >
										<div class="date">1-7-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-standing-order-donation" >
										<div class="desc-table">
											<h2 class="title">Initiation Society</h2>
											<h3 class="subtitle">STANDING ORDER </h3>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-down">
									<a href="#" data-toggle="modal" data-target="#modal-standing-order-donation" >
										<span class="balance-transition">
											£ 990.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td>
									STANDING ORDER
								</td>
							</tr>							
						</tbody>

					</table>

					<a href="" class="btn btn-primary view-more-transactions">View More Transactions</a>

				</div><!-- col 6 -->

				<div class="col-md-6">

					<h2>Latest Updates</h2>

					<div class="latest-update-desktop">
						SEP-14   ROSH HASHANAH UPDATE
						<p>The office will be closed Monday September 21 to Thursday the 24th. Please ensure all transactions are dealt with as soon as possible to avoid any issues given the high demand. Wishing everyone a ksiva v'chasima tova.  <a href="">READ MORE</a></p>
					</div>

					<h2>Quick Donation</h2>

					<form id="quick-donation">
					  <div class="form-group">
					    <label for="beneficiary">BENEFICIARY</label>
					    <input type="email" class="form-control" id="" placeholder="GGBH">
					  </div>
					  <div class="form-group">
					    <label for="amount">Amount</label>
					    <div class="row">
						    <div class="col-xs-9">
						    	<input type="text" class="form-control" id="" placeholder="3,989.00">
							</div>
							<div class="col-xs-3">
						    	<input type="text" class="form-control" id="" placeholder="3,989.00">
							</div>
						</div>
					  </div>
					  <div class="form-group">
					  	<a href="">+  ADD NOTES TO CHARITY</a>
					  </div><!-- / form group -->
					  <div class="form-group">
						<a href="#" class="ckeckbox">
							<span class="circle"></span>
							<span class="text">
								I confirm that this donation is for charitable purposes only, I will not benefit directly or indirectly by way of goods or services from the donation.
							</span>
						</a>
					   </div> 	
					  <button type="submit" class="btn btn-default">Make a Payment</button>
					</form>

				</div><!-- col 6 -->

			</div>

		</div><!-- /content-desktop-dashboard -->

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