<?
$section = '';
include 'inc/header.php'
?>
	
<main class="main-transactions main-transactions-result" >
	
	<div class="header-fixed">

        <header class="header ">

            <div class="container ">
			
				<div class="row">
					
					<div class="header-mobile-transactions">
						
						<div class="col-xs-3">
								
							<a href="#" class="go-back">
								
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

					<div class="title-transactions-result">
							
						<h3 class="title-transactions">SEARCH RESULTS</h3>

					</div><!-- /title-transactions-result -->
					
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

				<div class="empty-state">
					<p>Sorry, there are no results to display.</p>
					<ul>
						<li>Check your spelling, dates, or figures</li>
						<li>Try a different search tool</li>
					</ul>
					<span>OR</span>
					<a href="" class="empty-action">Get in touch with us</a>
				</div>

			</div><!-- /col -->
		
		</div><!-- /row -->
		
	</div><!-- /container-fluid -->

</main>	

<div class="modal-search modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  
  <div class="modal-dialog" role="document">
  
    <div class="modal-content">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
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
<? include 'inc/footer.php'?>