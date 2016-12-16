
                <div class="row-modal">

                    <h2 class="title-modal"><?php echo $title ?></h2>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">COMPANY NAME </h3>

                    <p class="info-modal" id="mdl_comp_name"><?php echo $t->Description ?></p>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">AMOUNT</h3>

                    <p class="info-modal" id="mdl_amount"><?php echo $t->>FormatAmount(false) ?></p>

                </div><!-- /row-modal -->

                <div class="row-modal">

                    <h3 class="subtitle-modal">DATE</h3>

                    <p class="info-modal" id="mdl_date"><?php echo $t->FormatDateTime() ?></p>

                </div><!-- /row-modal -->

                <a href="make-a-donation.php?id=<?php echo $t->CharityNumber ?>" id="lnk_donate_again" class="lkn-bottom-modal external-lkn" data-dismiss="modal" >Donate Again</a>
