<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';

session_start();

User::LoginCheck();

$faqList = new FaqList();
//$faqItem = new FaqItem();
$faqItems = $faqList->getFaqByRank();
?>
<main class="main-transactions main-help content-desktop">

    <div class="header-fixed visible-xs">

        <header class="header ">

            <div class="container ">

                <div class="row">

                    <div class="header-mobile-transactions">

                        <div class="col-xs-3">

                            <a href="dashboard.php" class="go-back">

                                <i class="fa fa-angle-left" aria-hidden="true"></i>

                            </a>

                        </div><!-- /col -->

                        <div class="col-xs-6">

                            <h2 class="title">Help</h2>

                        </div><!-- /col -->	

                        <div class="col-xs-3">

                            <a href="#" class="nav-mobile nav-icon4 visible-xs ">

                                <span></span>
                                <span></span>
                                <span></span>

                            </a>

                        </div><!-- /col -->	

                    </div><!-- /header-mobile-transactions -->

                </div><!-- /row  -->	

            </div><!-- /container  -->

        </header>

    </div><!-- /header-fixed -->


    <div class="box-faqs-header visible-xs">

        <div class="container-fluid">

            <h2 class="title-box-faqs">FAQs</h2>

            <p class="desc-box-faqs">Our FAQs answer our most commonly asked questions. If you think we've missed something or want to ask something else, please contact us.</p>

        </div><!-- /container -->

    </div><!-- /box-faqs-header -->

    <div class="container-faqs">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 col-xs-12 hidden-xs">

                    <div class="header-desktop">
                        <h2 class="title-desktop">Help</h2>
                    </div><!-- header-desktop -->

                </div><!-- /col -->

                <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

                    <div class="box-faqs-header hidden-xs">

                        <h2 class="title-box-faqs">FAQs</h2>

                        <p class="desc-box-faqs">Our FAQs answer our most commonly asked questions. If you think we've missed something or want to ask something else, please contact us.</p>

                    </div><!-- /box-faqs-header -->

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php 
                        for($i=0;$i < count($faqItems);$i++) {
                        $question=$faqItems[$i]->question ;
                        $answer=$faqItems[$i]->answer;
                        
                        ?>
                        <div class="panel panel-default">

                            <div class="panel-heading" role="tab" id="heading<?php echo $i+1; ?>">
                                <h4 class="panel-title">
                                    <a class="transaction-type-label" role="button" <?php if($i+1!=1){ echo 'class="collapsed"'; } ?> data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i+1; ?>" aria-expanded="<?php if($i+1==1){ echo 'true'; }else{ echo 'false';}?>" aria-controls="collapse<?php echo $i+1; ?>">
                                        <?php echo $question; ?>?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?php echo $i+1; ?>" class="panel-collapse collapse <?php if($i+1==1){ echo 'in'; } ?>"  role="tabpanel" aria-labelledby="heading<?php echo $i+1; ?>">
                                <div class="panel-body">
                                    <?php echo $answer; ?> 
                                </div>
                            </div>
                        </div><!-- /panel -->

                        <?php
                        }
                        /*
                          <div class="panel panel-default">

                          <div class="panel-heading" role="tab" id="headingTwo">
                          <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          SECOND QUESTION GOES HERE?
                          </a>
                          </h4>
                          </div>
                          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                          It is a small world after all. Globalization is that great process that started perhaps with Mr. Marco Polo, but has since regained its prestige after a short stint of protectionism following the great depression. It sure is great, isn’t it? I mean who doesn’t like globalization?
                          </div>
                          </div>
                          </div><!-- /panel -->

                          <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingThree">
                          <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          THIRD QUESTION GOES HERE?
                          </a>
                          </h4>
                          </div>
                          <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                          <div class="panel-body">
                          It is a small world after all. Globalization is that great process that started perhaps with Mr. Marco Polo, but has since regained its prestige after a short stint of protectionism following the great depression. It sure is great, isn’t it? I mean who doesn’t like globalization?
                          </div>
                          </div>
                          </div><!-- /panel -->

                          <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingfour">
                          <h4 class="panel-title">
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                          FORTH QUESTION GOES HERE?
                          </a>
                          </h4>
                          </div>
                          <div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
                          <div class="panel-body">
                          It is a small world after all. Globalization is that great process that started perhaps with Mr. Marco Polo, but has since regained its prestige after a short stint of protectionism following the great depression. It sure is great, isn’t it? I mean who doesn’t like globalization?
                          </div>
                          </div>
                          </div><!-- /panel -->

                          </div><!-- /panel-group --> */ ?>
                        <div class="hidden-xs box-find-answers">
                            <h2 class="title-footer">COULDN’T FIND THE ANSWER YOU NEED?</h2>

                            <a href="contact-us.php"  class="subtitle-footer transition external-lkn">CONTACT US</a>

                        </div>

                    </div><!-- /col -->

                </div><!-- /row -->

            </div><!-- /container -->

        </div><!-- /container-faqs -->

        <a href="#" class="sticky-to-footer visible-xs">

            <h2 class="title-footer">COULDN’T FIND THE ANSWER YOU NEED?</h2>

            <p  class="subtitle-footer">CONTACT US</p>

        </a>

</main>	