			
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
				<div class="half-row-modal">					
					<h3 class="subtitle-modal">DATE PROCESSED </h3>
	
					<p class="info-modal voucher-date" id="vo_mdl_dt_prcd"><?php echo $t->FormatDateTime() ?></p>
				</div>

				<div class="half-row-modal">
					<h3 class="subtitle-modal">TRANSACTION ID</h3>

					<p class="info-modal voucher-amount" id="vo_mdl_dnt_amt"><?php echo $t->RequestId?$t->RequestId:'N/A' ?></p>
				</div>

			</div><!-- /row-modal -->

			<div class="row-modal">
				
				<h3 class="subtitle-modal">VOUCHER NUMBER </h3>

				<p class="info-modal voucher-number" id="vo_mdl_vch_num"><?php echo $t->Voucher ?></p>

			</div><!-- /row-modal -->

                <div class="row-modal">
                    <h3 class="subtitle-modal">COMMENTS</h3>
                    <p class="info-modal" id="modal_notes_aac"><?php echo $t->client_comment ?></p>
                </div><!-- /row-modal -->
			<?php
			$param = $t->RequestId?"?id={$t->RequestId}&clone=1":"?charityId={$t->CharityNumber}&amount=".abs($t->Amount);
			?>
			<a href="make-a-donation.php<?php echo $param ?>" id="lnk_vch_donate_again" class="lkn-bottom-modal external-lkn" data-dismiss="modal" >Donate Again</a>
				
