			
			<div class="row-modal ">
				
				<h2 class="title-modal">VOUCHER </h2>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				
			</div><!-- /row-modal -->
			
			<div class="row-modal">
				
				<div class="half-row-modal">
					
					<h3 class="subtitle-modal">BENEFICIARY </h3>

					<p class="info-modal voucher-name" id="vo_mdl_beneficiary"><?php echo $t->Description ?></p>
				
				</div><!-- /row-modal -->

				<div class="half-row-modal">
					
					<h3 class="subtitle-modal">DONATION AMOUNT </h3>

					<p class="info-modal voucher-amount" id="vo_mdl_dnt_amt"><?php echo $t->FormatAmount(false) ?></p>
				
				</div><!-- /row-modal -->

			</div><!-- /row-modal -->

			<div class="row-modal">
				
				<h3 class="subtitle-modal">DATE PROCESSED </h3>

				<p class="info-modal voucher-date" id="vo_mdl_dt_prcd"><?php echo $t->FormatDateTime() ?></p>

			</div><!-- /row-modal -->

			<div class="row-modal">
				
				<h3 class="subtitle-modal">VOUCHER NUMBER </h3>

				<p class="info-modal voucher-number" id="vo_mdl_vch_num"><?php echo $t->Voucher ?></p>

			</div><!-- /row-modal -->
			
			<a href="make-a-donation.php?id=<?php echo $t->CharityNumber ?>" id="lnk_vch_donate_again" class="lkn-bottom-modal external-lkn" data-dismiss="modal" >Donate Again</a>
				
