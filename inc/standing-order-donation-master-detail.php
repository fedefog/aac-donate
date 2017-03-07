
                <div class="row-modal ">

                    <h2 class="title-modal"><?php echo $s->active=='Y'?'CURRENT':'PREVIOUS' ?> STANDING ORDER</h2>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div><!-- /row-modal -->
                
                <!-- AACDESING -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">BENEFICIARY</h3>

                    <p class="info-modal" id="modal_beneficiary1"><?php echo $s->name ?></p>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <div class="col">

                        <h3 class="subtitle-modal">ID</h3>

                        <p class="info-modal" id="modal_ID"><?php echo $s->id ?></p>

                    </div><!-- / col -->

                    <div class="col">

                        <h3 class="subtitle-modal">AMOUNT</h3>

                        <p class="info-modal" id="modal_Amount"><?php echo $s->FormatAmount(true) ?></p>

                    </div><!-- / col -->

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <div class="col">

                        <h3 class="subtitle-modal">DATE OF FIRST PAYMENT</h3>

                        <p class="info-modal" id="modal_first_payment"><?php echo ($sd=$s->FormatStartDate())?$sd:'&nbsp;'; ?></p>
                        
                    </div>

                    <div class="col">

                        <h3 class="subtitle-modal">END DATE</h3>

                        <p class="info-modal" id="modal_end_date"><?php echo ($ed=$s->FormatEndDate())?$ed:'&nbsp;' ?></p>

                    </div><!-- / col -->

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">INTERVAL</h3>

                    <p class="info-modal" id="modal_interval"><?php echo $s->FormatInterval() ?> (<?php echo $s->total_number_of_payments ?> payments in total)</p>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">SO PAID SO FAR</h3>

                    <p class="info-modal" id="modal_total_donate"><?php echo $s->FormatTotalAmountPaid() ?></p>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">NOTES TO ACC</h3>

                    <p class="info-modal" id="modal_acc_notes1"><?php echo $s->notes_to_aac ?></p>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">NOTES TO CHARITY</h3>

                    <p class="info-modal" id="modal_charity_notes1"><?php echo $s->notes_to_charity ?></p>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">NOTES TO SELF</h3>

                    <p class="info-modal" id="modal_self_notes1"><?php echo $s->notes_to_self ?></p>

                </div><!-- /row-modal -->

                <!-- END AACDESING -->

                <div class="row-modal">

                    <a href="standing-orders-transactions.php?id=<?php echo $s->id ?>" class="external-lkn view-all-dontation">VIEW DONATIONS</a>

                </div><!-- /row-modal -->

                <div class="btns-options">
                    <a href="#" data-toggle="modal" data-target="#modal-delete-transaction" class=" transition left-bt delete-transactions cancel-standing-order-bt">Cancel Standing Order</a>
                    <a href="amend-standing-order.php" class=" transition right-bt external-lkn">Amend Standing Order</a>
                </div><!-- / btns options -->

