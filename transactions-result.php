<main class="main-transactions main-transactions-result content-desktop" >
	
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

					<div class="title-transactions-result">
							
						<h3 class="title-transactions">SEARCH RESULTS</h3>

					</div><!-- /title-transactions-result -->

					<div class="clear"></div>

				</div><!-- /row  -->	
            
            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->

	<div id="transactions-navigation-desktop" class="hidden-xs transactions-navigation-desktop">

    	<div class="row">

    		<div class="col-md-6">
				
				<h2 class="title-transactions-desktop">Search Result </h2>

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

    </div><!-- /transactions-navigation-desktop -->
    
    <div class="container-fluid top-center-content ">

    	<div class="row">

    		<div class="col-xs-12">

				<ul class="navigator-transactions">
							
					<li class="navigator-transactions-li">
						
						<a href="#" class="navigator-transactions-lkn lkn-recent active">RECENT</a>

					</li>

					<li class="navigator-transactions-li">
						
						<a href="#" id="dates-bt-modal" class="navigator-transactions-lkn visible-xs">DATES</a>
						<input type="text"  id="config-date" class="form-control hidden-xs">
						<i class="glyphicon glyphicon-calendar fa fa-calendar hidden-xs"></i>
					</li>

					<li class="navigator-transactions-li">
						
						<a href="#" class="navigator-transactions-lkn lkn-search visible-xs" data-toggle="modal" data-target="#modal-search" >SEARCH</a>

					</li>

					<li class="navigator-transactions-li hidden-xs">
						
						<a href="#" class="navigator-transactions-lkn lkn-search  lkn-seach-desktop btn-dropdown-search"  >SEARCH</a>

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

				<div class="container-table">
			   
				   <table class="table-transactions table table-condensed">
						
						<thead class="hidden-xs "> 
							<tr>
								<th>DATE</th>
								<th>DESCRIPTION</th>
								<th>AMOUNT</th>
								<th class="hidden-xs">BALANCE AFTER TRANSACTION</th>
								<th class="hidden-xs">TYPE</th>
								<th class="hidden-xs">ACTION</th>
							</tr>
						</thead>						
						<tbody>
							<tr class="balance-down">
								<td data-toggle="modal" data-target="#modal-standing-order-donation" >
									<a href="#" >
										<div class="date">1-7-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-standing-order-donation" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Initiation Society</h2>
											<h3 class="subtitle">STANDING ORDER </h3>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-standing-order-donation" >
									<a href="#" >
										<span class="balance-transition">
											£ 990.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-down">
								<td data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<div class="date">24-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">FO Magen David Adom</h2>
											<h3 class="subtitle">VOUCHER </h3>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-down">
								<td data-toggle="modal" data-target="#modal-voucher-book" >
									<a href="#" >
										<div class="date">14-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-voucher-book" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">£1 Voucher Book £50</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-voucher-book" >
									<a href="#" >
										<span class="balance-transition">
											£ 50.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-up" >
								<td data-toggle="modal" data-target="#modal-comision" >
									<a href="#" >
										<div class="date">12-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-comision" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Commission</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-comision" >
									<a href="#" >
										<span class="balance-transition">
											£ 21.56
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-up" >
								<td data-toggle="modal" data-target="#modal-giftaid-rebate" >
									<a href="#" >
										<div class="date">9-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-giftaid-rebate" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Giftaid Rebate</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-giftaid-rebate" >
									<a href="#" >
										<span class="balance-transition">
											£ 233
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-up" >
								<td data-toggle="modal" data-target="#modal-give-as-you-earn" >
									<a href="#" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-give-as-you-earn" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Give as You Earn</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-give-as-you-earn" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-down">
								<td data-toggle="modal" data-target="#modal-online-donation" >
									<a href="#" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-online-donation" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Menorah Grammar</h2>
											<h3 class="subtitle">ONLINE DONATION </h3>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-online-donation" >
									<a href="#" >
										<span class="balance-transition">
											£ 222.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-down">
								<td data-toggle="modal" data-target="#modal-account-transfer" >
									<a href="#" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-account-transfer" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Account Transfer</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-account-transfer" >
									<a href="#" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-up" >
								<td data-toggle="modal" data-target="#modal-company-donation" >
									<a href="#" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-company-donation" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Company Donation</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-company-donation" >
									<a href="#" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>

							<tr class="balance-up" >
								<td data-toggle="modal" data-target="#modal-charity-donation" >
									<a href="#" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-charity-donation" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Charity Donation</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-charity-donation" >
									<a href="#" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-up" >
								<td data-toggle="modal" data-target="#modal-account-transfer" >
									<a href="#" >
										<div class="date">1-6-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-account-transfer" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Account Transfer</h2>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-account-transfer" >
									<a href="#" >
										<span class="balance-transition">
											£ 200.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
								</td>
							</tr>
							<tr class="balance-pending" >
								<td data-toggle="modal" data-target="#modal-standing-order-donation" >
									<a href="#" >
										<div class="date">1-7-16</div>
									</a>
								</td>
								<td data-toggle="modal" data-target="#modal-standing-order-donation" >
									<a href="#" >
										<div class="desc-table">
											<h2 class="title">Kol Yaakov</h2>
											<h3 class="subtitle">VOUCHER <span>PENDING</span></h3>
										</div><!-- /desc-table -->
									</a>
								</td>
								<td class="amount-td" data-toggle="modal" data-target="#modal-standing-order-donation" >
									<a href="#" >
										<span class="balance-transition">
											£ 990.00
											<i class="fa fa-caret-up" aria-hidden="true"></i>
											<i class="fa fa-caret-down" aria-hidden="true"></i>
											<i class="fa fa-caret-right" aria-hidden="true"></i>
										</span>
									</a>
								</td>
								<td class="amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" >
									<a href="#" >
										<span class="balance-transition">
											£ 550.00
										</span>
									</a>
								</td>
								<td class="type-td hidden-xs">
									<p class="type-transactions">VOUCHER</p>
								</td>
								<td class="action-edit hidden-xs">
									<a href="#" class="edit-transactions btn-trannsaction-accion"></a>
									<a href="#" class="delete-transactions btn-trannsaction-accion" data-toggle="modal" data-target="#modal-delete-transaction"></a>
									<a href="#" class="refresh-transactions btn-trannsaction-accion"></a>
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

<div class="modal-backdrop fade sort-back"></div>


<? include 'inc/online-donation-modal.php' ?>
<? include 'inc/give-as-you-earn-modal.php' ?>
<? include 'inc/giftaid-rebate-modal.php' ?>
<? include 'inc/comision-modal.php' ?>
<? include 'inc/voucher-book-modal.php' ?>
<? include 'inc/voucher-modal.php' ?>
<? include 'inc/standing-order-donation.php' ?>
<? include 'inc/company-donation-modal.php' ?>