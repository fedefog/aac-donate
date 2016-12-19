			
			<div class="row-modal">
				
				<h2 class="title-modal"><?php echo $title ?></h2>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				
			</div><!-- /row-modal -->

			<div class="row-modal">

				<h3 class="subtitle-modal">AMOUNT</h3>

				<p class="info-modal"><?php echo $t->FormatAmount(false) ?> </p>
				
			</div><!-- /row-modal -->

			<div class="row-modal">

				<h3 class="subtitle-modal">DATE</h3>

				<p class="info-modal"><?php echo $t->FormatDateTime() ?> </p>
				
			</div><!-- /row-modal -->

			<?php if($t->AACNotes) { ?>
			<div class="row-modal">
				
				<h3 class="subtitle-modal">NOTES FROM AAC</h3>

				<p class="info-modal">This is message user can input when making donation. Can be quite a lot of text. This is message user can input when making dona. </p>
				
			</div><!-- /row-modal -->
			<?php } ?>
