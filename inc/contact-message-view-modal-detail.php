			<div class="row-modal ">
				
				<h2 class="title-modal">
					<span class="date"><?php echo date('d M Y',$t->RequestDateTime) ?></span>
					Request ID <?php echo $t->id ?>
				</h2>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				
			</div><!-- /row-modal -->

			<div class="row-modal">
				<?php echo $t->OfficeComments ?>
			</div><!-- /row-modal --> 
			
			<a href="contact-us.php?id=<?php echo $t->id ?>" class="lkn-bottom-modal ajaxlink">Send Again</a>
