<?
$section = '';
include 'inc/header.php'
?>
	
<main class="main-transactions make-donation">
	
	<div class="header-fixed">

        <header class="header ">

            <div class="container ">
			
				<div class="row">
					
					<div class="header-mobile-transactions">
						
						<div class="col-xs-2">
								
							<a href="index.php" class="go-back">
								
								<i class="fa fa-angle-left" aria-hidden="true"></i>

							</a>
						
						</div><!-- /col -->

						<div class="col-xs-8">
							
							<h2 class="title">Make a Donation</h2>

						</div><!-- /col -->	
						
						<div class="col-xs-2">
							
							<a href="#" class="nav-mobile nav-icon4 visible-xs ">
			                                
			                    <span></span>
			                    <span></span>
			                    <span></span>

			                </a>

		                </div><!-- /col -->	

	                </div><!-- /header-mobile-transactions -->
					
					<div class="clear"></div>

				</div><!-- /row  -->	
            
            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->

    <div class="container top-center-content">

    	<div class="row">

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

			</div><!-- / col 12 -->

		</div><!-- / row -->

    </div><!-- / top center content -->

    <div class="box-slide-text">
	    
	    <div class="container">

			<a href="#" class="lkn-daily lkn-daily-donate">

				<p class="text"><strong>VOUCHERS FOR PURIM </strong>- Please make your orders by Tuesday 16th to ensure your vouchers can arrive for Purim.</p>
				<i class="fa fa-angle-down" aria-hidden="true"></i>
				<i class="fa fa-angle-up" aria-hidden="true"></i>

			</a>

		</div><!-- container -->
		
    </div><!-- /box-daily-updates -->
	
	<div class="container">
		
		<div class="box-make-donation ">
			
			<h2 class="title-make-donation">BENEFICIARY</h2>
			
			<select  title="Please select a Beneficiary" class="form-control selectpicker beneficiary-select select-1" data-style="btn-danger">
			  <option data-subtext="The Riding London NW11 8HL">GGBH</option>
			  <option data-subtext="The Riding London NW11 8HL">GGBH</option>
			  <option data-subtext="The Riding London NW11 8HL">GGBH</option>
			</select>

			<p class="text-danger beneficiary-select-error ">Please note: Achisomoch carries out random checks on the charitable status of the organisations mentioned on this list, However no guarantee is implied that all charities mentioned on this list are bona-fide.</p>
			
			<div class="box-make-donation-lkns">
				
				<a href="#" class="make-donation-lkns" >See previous donations to GGBH</a>

				<a href="#" class="make-donation-lkns" >Charity Commission profile</a>
				
			</div>

		</div><!-- /box-make-donation -->

		<div class="box-make-donation">
			
			<h2 class="title-make-donation">AMOUNT</h2>
			
			<div class="amount-input ">
				
				<input type="text" class="form-control input-text" placeholder="435" >


				<span class="numb-aprox">APROX. 299 GBP</span>

			</div><!-- /amount-input -->

			<div class="coin-amount ">
				
				<select class="form-control selectpicker">
				  <option>USD</option>
				  <option>GBP</option>
				  <option>£</option>
				  
				</select>

			</div><!-- /coin-amount -->

			<p class="text-danger amount-input-error">Please note that payments for under £100 may take longer to process.</p>

			<p class="large-amount">For your own safety and to comply with large donation regulations, please re-enter the amount you wish to donate. </p>

			<input type="text" class="form-control confirmation-amount input-text" placeholder="">

			<p class="text-danger confirmation-amount-error">This large donation will be eligible for random checks by our compliance office, given the regulations for large donations. Please be aware that there is a chance he may in touch to find out more information about this donation. </p>

		</div><!-- /box-make-donation -->

		<div class="box-make-donation">
			
			<h2 class="title-make-donation">NOTES TO CHARITY</h2>
			
			<textarea cols="30" rows="10" class="textarea-make-dontation" placeholder="Add any notes you'd wish to pass on the charity."></textarea>
			
		</div><!-- /box-make-donation -->

		<div class="box-make-donation">
			
			<h2 class="title-make-donation">NOTES TO AAC</h2>
			
			<textarea cols="30" rows="10" class="textarea-make-dontation" placeholder="Add any notes you'd wish to pass on to AAC."></textarea>
			
		</div><!-- /box-make-donation -->

		<div class="box-make-donation">
			
			<h2 class="title-make-donation">MY NOTES</h2>
			
			<textarea cols="30" rows="10" class="textarea-make-dontation" placeholder="Add any notes for your personal record keeping. These notes are searchable."></textarea>
			
		</div><!-- /box-make-donation -->

		<div class="box-make-donation standing-order-switch-container">
			
			<div class="half-make-donation">
				
				<h2 class="title-make-donation">STANDING ORDER</h2>
			
				<input type="checkbox" id="standing-order-switch" name="my-checkbox">
				
			</div><!-- /half-make-donation -->

			<div class="half-make-donation">
				
				<h2 class="title-make-donation">PAYMENTS</h2>
			
				<select class="form-control selectpicker" disabled>
				  <option>ONGOING</option>
				  <option>ONGOING</option>
				  <option>ONGOING</option>
				  <option>ONGOING</option>
				  <option>ONGOING</option>
				</select>

			</div><!-- /half-make-donation -->

			<div class="half-make-donation">
				
				<h2 class="title-make-donation">STARTING </h2>
			
				<select class="form-control selectpicker" disabled>
				  <option>JUN 15th</option>
				  <option>JUN 15th</option>
				  <option>JUN 15th</option>
				  <option>JUN 15th</option>
				  <option>JUN 15th</option>
				</select>

			</div><!-- /half-make-donation -->

			<div class="half-make-donation">
				
				<h2 class="title-make-donation">INTERVAL </h2>
			
				<select class="form-control selectpicker" disabled>
				  <option>MONTHLY</option>
				  <option>MONTHLY</option>
				  <option>MONTHLY</option>
				  <option>MONTHLY</option>
				  <option>MONTHLY</option>
				</select>

			</div><!-- /half-make-donation -->
			
		</div><!-- /box-make-donation -->

	</div><!-- /container -->

	<div class="checkbox-box ">
		
		<div class="container">
			
			<a href="#" class="ckeckbox">
				<span class="circle"></span>
				<span class="text">
					I confirm that this donation is for charitable purposes only, I will not benefit directly or indirectly by way of goods or services from the donation.
					<p class="text-danger">Please confirm to continue</p>
				</span>
			</a>
			
		</div><!-- /container -->

	</div><!-- /checkbox -->
	
	<a href="#" class="sticky-to-footer make-dontation">Make Donation</a>
	
</main>	



<? include 'inc/footer.php'?>