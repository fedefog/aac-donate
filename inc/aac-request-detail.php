
                <div class="row-modal ">
                    <h2 class="title-modal"><?php echo $t->Request ?></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- /row-modal -->


                <div class="row-modal">
                    <h3 class="subtitle-modal">SUMMARY </h3>
                    <p class="info-modal" id="modal_beneficiary"><?php echo $t->FormatSummary() ?></p>
                </div><!-- /row-modal -->

                <div class="row-modal">
                    <h3 class="subtitle-modal">NOTES TO AAC</h3>
                    <p class="info-modal" id="modal_notes_aac"><?php echo $t->OfficeComments ?></p>
                </div><!-- /row-modal -->
                <div class="row-modal">
                    <h3 class="subtitle-modal">NOTES TO SELF</h3>
                    <p class="info-modal" id="modal_charity_notes"><?php echo $t->UserComments ?></p>
                </div><!-- /row-modal -->
                <div class="row-modal">
                    <h3 class="subtitle-modal">NOTES TO CHARITY</h3>
                    <p class="info-modal" id="modal_charity_notes"><?php echo $t->ClientComments ?></p>
                </div><!-- /row-modal -->

<?phhp /**
                <div class="row-modal">
                    <h3 class="subtitle-modal">BENEFICIARY </h3>
                    <p class="info-modal" id="modal_beneficiary"><?php echo $t->Description ?></p>
                </div><!-- /row-modal -->
                <div class="row-modal">
                    <h3 class="subtitle-modal">DATE PAID </h3>
                    <p class="info-modal" id="modal_date_paid"><?php echo $t->FormatDateTime(); ?></p>
                </div><!-- /row-modal -->
                <div class="row-modal">
                    <h3 class="subtitle-modal">DONATION AMOUNT </h3>
                    <p class="info-modal" id="modal_amount"><?php echo $t->FormatAmount(false); ?></p>
                </div><!-- /row-modal -->
                <div class="row-modal">
                    <h3 class="subtitle-modal">PAYMENTS NUMBER </h3>
                    <p class="info-modal" id="modal_payments_number"><?php echo $t->PaymentNumber ?></p>
                </div><!-- /row-modal -->

                <div class="row-modal">
                    <a href="#" class="view-all-dontation external-lkn" data-dismiss="modal" id="lnk_view_all">VIEW ALL DONATIONS WITHIN THIS STANDING ORDER</a>
                </div><!-- /row-modal -->
**/ ?>
