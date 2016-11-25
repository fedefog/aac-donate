<div class="navigator">

    <div class="inner-navigator">

        <a href="#" class="close-nav">&times;</a>

        <?php /* <h2 class="name-navigator">David Jacobs</h2> */ ?>
        <?php
        if (count($account) > 1) {
            ?>
            <select class="form-control selectpicker switch-account" title="Switch Account">
                <option><?php echo $account; ?></option>
            </select>
            <?php
        }
        ?>
        <div class="navigator-account-header">

            <div class="navigator-account">

                <h2 class="title">ACCOUNT</h2> 

                <h3 class="account-number"><?php echo $account; ?></h3>

            </div><!-- /box-account -->

            <div class="navigator-balance">

                <h2 class="title">BALANCE</h2>

                <h3 class="balance-number">£ <?php echo $balance; ?></h3>

            </div><!-- /box-balance -->

        </div><!-- /box-account-header -->


        <div class="hoverflow">

            <div class="inner-hoverflow">

                <h3 class="time-navigator">AS OF <strong><?php echo $date; ?></strong></h3>

                <ul class="list-navigator">

                    <li class="navigator-li li-dashboard anim-li">

                        <a href="dashboard.php" class="navigator-lkn">

                            <span class="icon">
                                <img src="./images/dashboard-icon.png" width="22" height="20">
                            </span>

                            <span class="text">Dashboard</span>

                        </a>

                    </li>

                    <li class="navigator-li anim-li">

                        <a href="help.php" class="navigator-lkn">

                            <span class="icon">
                                <img src="./images/help-icon.png" width="20.5" height="20">
                            </span>

                            <span class="text">Help</span>

                        </a>

                    </li>

                    <li class="navigator-li anim-li">

                        <a href="contact-us.php" class="navigator-lkn">

                            <span class="icon">
                                <img src="./images/contact-icon.png" width="24" height="20.5">
                            </span>

                            <span class="text">Contact us</span>

                        </a>

                    </li>

                    <li class="navigator-li anim-li">

                        <a href="invite-a-friend.php" class="navigator-lkn">

                            <span class="icon">
                                <img src="./images/invite-a-friend-icon.png" width="20.5" height="20">
                            </span>

                            <span class="text">Invite a Friend - <em>Earn £100 credit</em></span>

                        </a>

                    </li>

                    <li class="navigator-li anim-li">

                        <a href="settings.php" class="navigator-lkn">

                            <span class="icon">
                                <img src="./images/settings-icon.png" width="20" height="20">
                            </span>

                            <span class="text">Settings</span>

                        </a>

                    </li>

                </ul>

                <a href="#" class="lkn-logout" data-toggle="modal" data-target="#modal-logout">

                    <span class="icon">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </span>

                    <span class="text">Logout</span>

                </a>
            </div><!-- /inner -->

        </div><!-- /inner-hoverflow -->

    </div><!-- /inner -->	
</div><!-- /navigator -->

<div class="layer-navigator"></div><!-- /layer-navigator -->