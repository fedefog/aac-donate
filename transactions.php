<?
$section = '';
include 'inc/header.php'
?>
	
<main class="main-transactions">
	
	<div class="header-fixed">

        <header class="header ">

            <div class="container ">
			
				<div class="row">
					
					<div class="header-mobile-transactions">
						
						<div class="col-xs-3">
								
							<a href="index.php" class="go-back">
								
								<i class="fa fa-angle-left" aria-hidden="true"></i>

							</a>
						
						</div><!-- /col -->

						<div class="col-xs-6">
							
							<h2 class="title">Transactions</h2>

						</div><!-- /col -->	
						
						<div class="col-xs-3">
							
							<a href="#" class="nav-mobile nav-icon4 visible-xs ">
			                                
			                    <span></span>
			                    <span></span>
			                    <span></span>

			                </a>

		                </div><!-- /col -->	

	                </div><!-- /header-mobile-transactions -->

	                <div class="col-xs-12 header-mobile-transactions">

	                	<ul class="nav-transactions">
	                		
	                		<li class="nav-transactions-li">
	                		
	                			<a href="#" class="nav-transactions-lkn active">all</a>
	                		
	                		</li>

	                		<li class="nav-transactions-li">
	                		
	                			<a href="#" class="nav-transactions-lkn">in</a>
	                		
	                		</li>

	                		<li class="nav-transactions-li">
	                		
	                			<a href="#" class="nav-transactions-lkn">out</a>
	                		
	                		</li>

	                	</ul>

	                </div><!-- /header-mobile-transactions -->

					<div class="col-xs-12">
                	
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

						<h3 class="time-update">AS OF <strong>1 SEP 2016, 2:15PM</strong></h3>

					</div><!-- /col -->
					
					<div class="col-xs-12">
						
						<ul class="navigator-transactions">
							
							<li class="navigator-transactions-li">
								
								<a href="#" class="navigator-transactions-lkn active">RECENT</a>

							</li>

							<li class="navigator-transactions-li">
								
								<a href="#" class="navigator-transactions-lkn">DATES</a>

							</li>

							<li class="navigator-transactions-li">
								
								<a href="#" class="navigator-transactions-lkn" data-toggle="modal" data-target="#modal-search" >SEARCH</a>

							</li>

							<li class="navigator-transactions-li">
								
								<a href="#" class="navigator-transactions-lkn lkn-sortby">
									
									<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>

								</a>
								
								<div class="drop-down-sort">

									<div class="container-sortby">

										<ul class="list-sortby">
											<li class="sortby-li">
												<h2 class="title-sortby">SORT BY</h2>
											</li>
											<li class="sortby-li">
												<a href="#" class="sortby-lkn">Date (Recent - Furthest)</a>
											</li>
											<li class="sortby-li">
												<a href="#" class="sortby-lkn">Date (Furthest - Recent)</a>
											</li>
											<li class="sortby-li">
												<a href="#" class="sortby-lkn">Amount (High - Low)</a>
											</li>
											<li class="sortby-li">
												<a href="#" class="sortby-lkn">Amount (Low - High)</a>
											</li>
											<li class="sortby-li">
												<a href="#" class="sortby-lkn">Charity Name (A - Z)</a>
											</li>
											<li class="sortby-li">
												<a href="#" class="sortby-lkn">Charity Name (Z - A)</a>
											</li>
										</ul>
									
									</div><!-- /container-sortby -->

								</div><!-- /drop-down-sort -->

							</li>

						</ul>
						
					</div><!-- /col -->

					<div class="clear"></div>

				</div><!-- /row  -->	
            
            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->
	
    <div class="container-fluid">
	
		<div class="row">
		
			<div class="col-xs-12">

				<div class="container-table">
			   
				   <table class="table-transactions table table-condensed">
						
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
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-voucher" >
										<div class="date">24-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-voucher" >
										<div class="desc-table">
											<h2 class="title">FO Magen David Adom</h2>
											<h3 class="subtitle">VOUCHER </h3>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-down">
									<a href="#" data-toggle="modal" data-target="#modal-voucher" >
										<span class="balance-transition">
											£ 550.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-voucher-book" >
										<div class="date">14-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-voucher-book" >
										<div class="desc-table">
											<h2 class="title">£1 Voucher Book £50</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-down">
									<a href="#" data-toggle="modal" data-target="#modal-voucher-book" >
										<span class="balance-transition">
											£ 50.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-comision" >
										<div class="date">12-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-comision" >
										<div class="desc-table">
											<h2 class="title">Commission</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-up">
									<a href="#" data-toggle="modal" data-target="#modal-comision" >
										<span class="balance-transition">
											£ 21.56
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-giftaid-rebate" >
										<div class="date">9-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-giftaid-rebate" >
										<div class="desc-table">
											<h2 class="title">Giftaid Rebate</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-up">
									<a href="#" data-toggle="modal" data-target="#modal-giftaid-rebate" >
										<span class="balance-transition">
											£ 233
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-give-as-you-earn" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-give-as-you-earn" >
										<div class="desc-table">
											<h2 class="title">Give as You Earn</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-up">
									<a href="#" data-toggle="modal" data-target="#modal-give-as-you-earn" >
										<span class="balance-transition">
											£ 550.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-online-donation" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-online-donation" >
										<div class="desc-table">
											<h2 class="title">Menorah Grammar</h2>
											<h3 class="subtitle">ONLINE DONATION </h3>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-down">
									<a href="#" data-toggle="modal" data-target="#modal-online-donation" >
										<span class="balance-transition">
											£ 222.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-account-transfer" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-account-transfer" >
										<div class="desc-table">
											<h2 class="title">Account Transfer</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-down">
									<a href="#" data-toggle="modal" data-target="#modal-account-transfer" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-company-donation" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-company-donation" >
										<div class="desc-table">
											<h2 class="title">Company Donation</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-up">
									<a href="#" data-toggle="modal" data-target="#modal-company-donation" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-charity-donation" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-charity-donation" >
										<div class="desc-table">
											<h2 class="title">Charity Donation</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-up">
									<a href="#" data-toggle="modal" data-target="#modal-charity-donation" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-account-transfer" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-account-transfer" >
										<div class="desc-table">
											<h2 class="title">Account Transfer</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-up">
									<a href="#" data-toggle="modal" data-target="#modal-account-transfer" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-logout" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-logout" >
										<div class="desc-table">
											<h2 class="title">Test</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="balance-up">
									<a href="#" data-toggle="modal" data-target="#modal-logout" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
							</tr>
							
						</tbody>

					</table>
				
				</div><!-- /container-table -->

			</div><!-- /col -->
		
		</div><!-- /row -->
		
	</div><!-- /container-fluid -->

</main>	

<div class="modal-search modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  
  <div class="modal-dialog" role="document">
  
    <div class="modal-content">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>    	
  
      <div class="modal-body">
  
		<form class="form-modal-search">
									
			<div class="form-group">
				<label for="" class="label">TRANSACTION ID</label>
				<div class="row-input">
					<a href="#" class="checkbox-input">
						<i class="fa fa-check" aria-hidden="true"></i>
					</a>
					<input type="text" class="input" placeholder="For a specific transaction.">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="label">CHARITY NAME</label>
				<div class="row-input">
					<a href="#" class="checkbox-input">
						<i class="fa fa-check" aria-hidden="true"></i>
					</a>
					<input type="text" class="input" placeholder="Please enter the name of the charity">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="label">AMOUNT DONATED</label>
				<div class="row-input">
					<a href="#" class="checkbox-input">
						<i class="fa fa-check" aria-hidden="true"></i>
					</a>
					<input type="text" class="input" placeholder="For a specific amount that has been donated.">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="label">PERSONAL NOTES</label>
				<div class="row-input">
					<a href="#" class="checkbox-input">
						<i class="fa fa-check" aria-hidden="true"></i>
					</a>
					<input type="text" class="input" placeholder="Search your personal notes">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="label">VOUCHER NUMBER</label>
				<div class="row-input">
					<a href="#" class="checkbox-input">
						<i class="fa fa-check" aria-hidden="true"></i>
					</a>
					<input type="text" class="input" placeholder="Enter voucher number or range (from and to)">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="label">BOOK VOUCHER NUMBER</label>
				<div class="row-input">
					<a href="#" class="checkbox-input">
						<i class="fa fa-check" aria-hidden="true"></i>
					</a>
					<input type="text" class="input" placeholder="To display all vouchers in a book.">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="label">TRANSACTION TYPE</label>
				<div class="row-input">
					<a href="#" class="checkbox-input">
						<i class="fa fa-check" aria-hidden="true"></i>
					</a>
					<input type="text" class="input" placeholder="Select the type of transactions ">
				</div>
			</div>
			
			<a href="transactions-result.php" class="btn-search">Search Transactions</a>

		</form>

      </div><!-- /modal-body -->

    </div><!-- /modal-content -->

  </div><!-- /modal-dialog -->

</div><!-- /modal-search -->


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