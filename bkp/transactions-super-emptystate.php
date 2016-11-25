<main class="main-transactions ">
	
    <div class="container-fluid">
	
		<div class="row">
		
			<div class="col-xs-12">

				<div class="line"></div>

				<div class="super-empty-state">					

					<h2 class="empty-title">In order to begin making donations from your account, please transfer funds into your account.</h2>

					<p>(if you're already done so, they will be shown shortly)</p>

					<strong>To transfer funds, either:</strong>

					<p><span class="empty-number">1</span>Send a cheque made payable to 'Achisomoch' to 35 Templars Avenue, London, NW11 0NU</p>

					<strong>OR </strong>

					<p><span class="empty-number">2</span>Transfer funds to our bank account:</p>

					<div class="bank-account">
						Barclays<br>
						126 Station Road,<br>
						Edgware, Middx. HA8 7RY<br>
						Achisomoch Aid Co. Ltd.<br>
						<br>
						Sort Code 20-29-37<br>
						Account no 2033 2003
					</div>

					<p><span>Please mention your name and client number as the reference.</span></p>
					
				</div>

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
<? include 'inc/previous-standing-order-modal.php' ?>