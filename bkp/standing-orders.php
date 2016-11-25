
<main class="standing-orders content-desktop" >
	
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
							
							<h2 class="title">View Standing Orders</h2>

						</div><!-- /col -->	
						
						<div class="col-xs-2">
							
							<a href="#" class="nav-mobile nav-icon4 visible-xs ">
			                                
			                    <span></span>
			                    <span></span>
			                    <span></span>

			                </a>

		                </div><!-- /col -->	

	                </div><!-- /header-mobile-transactions -->

	                <div class="col-xs-12 header-mobile-transactions">

	                	<ul class="nav-standing-orders">
	                		
	                		<li class="nav-standing-orders-li">
	                		
	                			<a href="standing-orders-current.php" class="nav-standing-orders-lkn active">CURRENT</a>
	                		
	                		</li>

	                		<li class="nav-standing-orders-li">
	                		
	                			<a href="standing-orders-previous.php" class="nav-standing-orders-lkn">PREVIOUS</a>
	                		
	                		</li>

	                	</ul>

	                </div><!-- /header-mobile-transactions -->

					<div class="clear"></div>

				</div><!-- /row  -->	
            
            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->

    <div class="header-desktop-orders hidden-xs">
    	
    	<div class="row">
	    	
	    	<div class="col-md-12">
	    		
	    		<h2 class="title-orders">View Standing Orders</h2>

	    	</div><!-- /col -->

	    	<div class="col-md-7">

		    	<ul class="nav-standing-orders ">
			                		
		    		<li class="nav-standing-orders-li">
		    		
		    			<a href="standing-orders-current.php" class="nav-standing-orders-lkn active">CURRENT</a>
		    		
		    		</li>

		    		<li class="nav-standing-orders-li">
		    		
		    			<a href="standing-orders-previous.php" class="nav-standing-orders-lkn">PREVIOUS</a>
		    		
		    		</li>

		    	</ul>
			
			</div><!-- /col -->
			
			<div class="col-md-5 text-right">
			
				<div class="export-file">
	    			EXPORT DATA <span class="caret"></span>
	    			<ul class="transition">
	    				<li><a class="transition" href="">CSV File</a></li>
						<li><a class="transition" href="">XLS File</a></li>
					</ul>
				</div>
			
			</div><!-- / col 6 -->

		</div><!-- /row -->

    </div><!-- /header-desktop-orders -->
	
    <div class="container-fluid no-padding-desktop">
	
		<div class="row">
		
			<div class="col-xs-12">

				<div class="container-table ajax-standing">
			   
				   <? include 'standing-orders-current.php' ?>
				
				</div><!-- /container-table -->

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
<? include 'inc/current-standing-order-modal.php' ?>
<? include 'inc/previous-standing-order-modal.php' ?>
