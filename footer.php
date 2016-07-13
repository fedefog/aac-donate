     
    <footer id="footer">
        
        <div class="row touch-row">

            <div class="container">
                
                <div class="col-md-4 col-sm-3">

                    <div class="img-left"></div>

                </div>         

                <div class="col-md-4 col-sm-6">

                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="get-touch">Get in Touch with the team!</a>

                </div> 

                <div class="col-md-4 col-sm-3">
                    
                    <div class="img-right"></div>

                </div>         

            </div>

        </div><!-- /row -->

        <div class="row footer">
 
            <div class="container">
 
                <div class="col-md-5 col-sm-12">
 
                    <div class="footer-navigation">
 
                        <h2>navigation</h2>
    
                        <ul>
    
                            <li>
 
                                <a href="<?php echo esc_url( home_url( ) ); ?>" class="active">Home</a>
 
                            </li>
 
                            <li>
 
                                <a href="<?php echo esc_url( home_url( '/cufflinks/' ) ); ?>">Cufflinks</a>
 
                            </li>
 
                            <li>
 
                                <a href="<?php echo esc_url( home_url( '/badges/' ) ); ?>">Badges</a>
 
                            </li>
 
                            <li>
 
                                <a href="<?php echo esc_url( home_url( '/custom-products/' ) ); ?>">Custom Products</a>
 
                            </li>
 
                            <li>
 
                                <a href="<?php echo esc_url( home_url( '/keyrings/' ) ); ?>">Keyrings</a>
 
                            </li>
 
                            <li>
 
                                <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Us</a>
 
                            </li>
 
                            <li>
 
                                <a href="<?php echo esc_url( home_url( '/medals/' ) ); ?>">Medals</a>
 
                            </li>
 
                            <li>
 
                                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
 
                            </li>

                        </ul>

                    </div>

                </div>

                <div class="col-md-4 col-sm-12">

                    <div class="footer-contact">

                        <h2>contact us</h2>

                        <ul>

                            <li class="address">

                                <a href="#">

                                    <span><i class="fa fa-map-marker"></i></span><?php the_field('address', 'option'); ?>

                                </a>

                            </li>

                            <li class="email">

                            <?php $email = get_field ('email_address','option'); ?>

                                <a href="mailto:<?php echo $email; ?>">

                                    <span><i class="fa fa-envelope"></i></span><?php echo $email; ?>

                                </a>

                            

                            </li>

                            <li class="phone">

                                <?php $phone = get_field ('phone_number','option'); ?>

                                <a href="tel:<?php echo $phone; ?>">

                                    <span><i class="fa fa-phone"></i></span><?php echo $phone; ?>

                                </a>

                            </li>                           

                        </ul>

                    </div>

                </div>

                <div class="col-md-3 col-sm-12">

                    <h2>Payment Methods</h2>

                    <div class="footer-payment">

                    </div>

                </div>        

            </div>

        </div>

        <div id="sister-companies">
            <div class="w-container">
                <h2>Sister Companies</h2> <span></span>
                <div class="sister-links">
                    <a href="http://www.rocketbags.co.uk/" class="rocket-bags-link" target="_blank">Rocket Bags</a>
                    <a href="http://rocketcharities.co.uk/" class="rocket-charities-link" target="_blank">Rocket Charities</a>
                    <a href="http://rocketkeyrings.co.uk/" class="rocket-keyrings-link" target="_blank">Rocket Keyrings</a>
                    <a href="http://rocketpromo.co.uk/" class="rocket-promo-link" target="_blank">Rocket Promo</a>
                </div>
            
            </div>
        </div>

        <div class="row sub-footer">

            <div class="container">

                <div class="col-md-12">

                <h2><?php the_field('first_line', 'option'); ?></h2>
                
                <p><?php the_field('copyright_description', 'option'); ?></p>

                <a href="#">TERMS AND CONDITIONS</a>

                </div>

            </div>

        </div>

    </footer><!-- /footer -->

    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/bootstrap.min.js"></script>
    <!-- Hover dropdown -->
    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/bootstrap-hover-dropdown.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/jquery.easing.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false" ></script>

    <!-- Read More -->
    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/readmore.min.js"></script>

    <!-- Custom Theme JavaScript -->
    
    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/plugins.js"></script>
    
    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/main.js"></script>

    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/jquery.flexslider-min.js"></script>

    <script src="<?php bloginfo ( 'stylesheet_directory' ); ?>/js/script.js"></script>

    <?php wp_footer(); ?>

    </body>
    
</html>