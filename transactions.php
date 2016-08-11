
<main class="main-transactions content-desktop" >
	
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
	                		
	                			<a href="transactions-all.php" class="nav-transactions-lkn active">all</a>
	                		
	                		</li>

	                		<li class="nav-transactions-li">
	                		
	                			<a href="transactions-in.php" class="nav-transactions-lkn">in</a>
	                		
	                		</li>

	                		<li class="nav-transactions-li">
	                		
	                			<a href="transactions-out.php" class="nav-transactions-lkn">out</a>
	                		
	                		</li>

	                	</ul>

	                </div><!-- /header-mobile-transactions -->

					<div class="clear"></div>

				</div><!-- /row  -->	
            
            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->

    <div id="transactions-navigation-desktop" class="hidden-xs transactions-navigation-desktop">

    	<div class="row">

    		<div class="col-md-6">
				
				<h2 class="title-transactions-desktop">Transactions</h2>

    			<ul class="nav-transactions">
	                		
            		<li class="nav-transactions-li">
            		
            			<a href="transactions-all.php" class="nav-transactions-lkn active">all</a>
            		
            		</li>

            		<li class="nav-transactions-li">
            		
            			<a href="transactions-in.php" class="nav-transactions-lkn">in</a>
            		
            		</li>

            		<li class="nav-transactions-li">
            		
            			<a href="transactions-out.php" class="nav-transactions-lkn">out</a>
            		
            		</li>

            	</ul>

    		</div><!-- / col 6 -->

    		<div class="col-md-6 text-right">
    			<a href="#" class="expert-csv-file">EXPORT DATA TO CSV FILE</a>
    			<a href="#" class="expert-xls-file">EXPORT DATA TO XLS FILE</a>
    		</div><!-- / col 6 -->

		</div><!-- / row -->

    </div>

    <div class="container-fluid top-center-content">

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

				<ul class="navigator-transactions">
							
					<li class="navigator-transactions-li">
						
						<a href="#" class="navigator-transactions-lkn lkn-recent active">RECENT</a>

					</li>

					<li class="navigator-transactions-li">
						
						<a href="#" id="dates-bt-modal" class="navigator-transactions-lkn">DATES</a>

					</li>

					<li class="navigator-transactions-li">
						
						<a href="#" class="navigator-transactions-lkn lkn-search" data-toggle="modal" data-target="#modal-search" >SEARCH</a>

					</li>

					<li class="navigator-transactions-li navigator-transactions-sortby ">
						
						<a href="#" class="navigator-transactions-lkn lkn-sortby">
							<span class="text hidden-xs">SORT BY</span>
							<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>

						</a>
						
						<div class="drop-down-sort">

							<a href="#" class="navigator-transactions-lkn lkn-sortby">
								<span class="text hidden-xs">SORT BY</span>
								<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>

							</a>

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

			</div><!-- / col 12 -->

		</div><!-- / row -->

    </div><!-- / top center content -->
	
    <div class="container-fluid">
	
		<div class="row">
		
			<div class="col-xs-12">

				<div class="container-table ajax-transaction">
			   
				   <? include 'transactions-all.php' ?>
				
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
<div class="modal-backdrop fade sort-back"></div>


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