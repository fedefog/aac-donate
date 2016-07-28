<?
$section = '';
include 'inc/header.php'
?>
	
<main class="main-transactions main-settings" >
	
	<div class="header-fixed">

        <header class="header ">

            <div class="container ">
			
				<div class="row">
					
					<div class="header-mobile-transactions">
						
						<div class="col-xs-3">
								
							<a href="index.php" class="go-back">
								
								<i class="fa fa-angle-left" aria-hidden="true"></i>

							</a>
						
						</div><!-- /col -->

						<div class="col-xs-6">
							
							<h2 class="title">Settings</h2>

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
	
    <div class="container-fluid ">
	
		<div class="row">
		
			<div class="col-xs-12">
				
				<div class="container-settings">
					
					<div class="box-settings">
						
						<div class="box-settings-info">
							
							<h2 class="title-settings">DISPLAY MY NAME </h2>

							<p class="info-settings">By enabling this option your name will be displayed in various pages.</p>

						</div><!-- /box-settings-info -->
						
						<input type="checkbox" class="switch-settings" name="my-checkbox" checked>
						
					</div><!-- /box-settings -->

				</div><!-- /container-settings -->

				<div class="container-settings">
					
					<div class="box-settings">
						
						<div class="box-settings-info">
							
							<h2 class="title-settings">AUTOMATIC LOGIN </h2>

							<p class="info-settings">By enabling this option you will not have to enter your username and password to login.</p>

						</div><!-- /box-settings-info -->
						
						<input type="checkbox" class="switch-settings" id="checkbox-automatic-login" name="my-checkbox" >
						
					</div><!-- /box-settings -->
					
					<div class="default-login">
						
						<div class="box-settings">
							
							<div class="box-settings-info">
								
								<h2 class="title-settings">DEFAULT LOGIN ACCOUNT </h2>

								<select class="form-control selectpicker">
									<option>ACCOUNT      A9895</option>
									<option>ACCOUNT      A9895</option>
									<option>ACCOUNT      A9895</option>
									<option>ACCOUNT      A9895</option>
									<option>ACCOUNT      A9895</option>
								</select>

							</div><!-- /box-settings-info -->
							
						</div><!-- /box-settings -->

					</div><!-- /default-login -->


				</div><!-- /container-settings -->

				<div class="container-settings">
					
					<div class="box-settings">
						
						<div class="box-settings-info">
							
							<h2 class="title-settings">ENABLE SMS SETTINGS </h2>

							<p class="info-settings">AAC can send you alert text messages. </p>

						</div><!-- /box-settings-info -->
						
						<input type="checkbox" class="switch-settings" id="chebox-sms" name="my-checkbox" >
						
					</div><!-- /box-settings -->
					
					<div class="container-settings-msj">

						<div class="box-settings box-settings-msj">
							
							<div class="box-settings-info">
								
								<h2 class="title-settings title-send">Send SMS when </h2>

								<p class="info-settings">my account balance is lower than: </p>

								<span class="price-settings"> £ 0,00 </span>
								
							</div><!-- /box-settings-info -->
							
							<input type="checkbox" class="switch-settings" name="my-checkbox" >
							
						</div><!-- /box-settings -->

						<div class="box-settings box-settings-msj">
							
							<div class="box-settings-info">
								
								<h2 class="title-settings title-send">Send SMS when </h2>

								<p class="info-settings">I receive an incoming payment more than:</p>

								<span class="price-settings"> £ 0,00 </span>
								
							</div><!-- /box-settings-info -->
							
							<input type="checkbox" class="switch-settings" name="my-checkbox" >
							
						</div><!-- /box-settings -->

						<div class="box-settings box-settings-msj">
							
							<div class="box-settings-info">
								
								<h2 class="title-settings title-send">Send SMS when </h2>

								<p class="info-settings">I make an outgoing payment of more than:</p>
								
								<span class="price-settings"> £ 0,00 </span>

							</div><!-- /box-settings-info -->
							
							<input type="checkbox" class="switch-settings" name="my-checkbox" >
							
						</div><!-- /box-settings -->

						<div class="box-phone-numb-settings">
							
							<h2 class="title-settings">MOBILE PHONE NUMBER TO TEXT </h2>
							
							<form class="form-phone-number">
							
							  <div class="form-group">
							    
							    <div class="input-group">

							      <div class="input-group-addon">PHONE NUMBER</div>
							      
							      <input type="text" class="form-control phone-number-input" >
							    
							    </div><!-- /input-group -->

							  </div><!-- /form-group -->

							</form>							

						</div>

					</div><!-- /container-mjs -->

				</div><!-- /container-settings -->

				<div class="container-settings">
					
					<a href="#" class="lkn-change-password">
						
						<div class="box-settings">
							
							<div class="box-settings-info">
								
								<h2 class="title-settings">CHANGE PASSWORD </h2>

								<p class="info-settings">Easily update your password.</p>

							</div><!-- /box-settings-info -->						
													
						</div><!-- /box-settings -->

					</a>

					<form class="container-password-settings">
						
						<div class="box-settings-password">

							<h2 class="title-password-settings">CHANGE PASSWORD </h2>

					      	<input type="password" class="form-control" placeholder="Enter current password">
					      	
					      	<a href="#" class="forgot-password">Forgot your password ? - Get in touch with us</a>

				      	</div><!-- /box-settings-password -->

						<div class="box-settings-password">

							<h2 class="title-password-settings">NEW PASSWORD </h2>

					      	<input type="password" class="form-control" placeholder="Choose new password">
					      	
				      	</div><!-- /box-settings-password -->

						<div class="box-settings-password">

							<h2 class="title-password-settings">VERIFY PASSWORD</h2>

					      	<input type="password" class="form-control" placeholder="Confirm new password">

				      	</div><!-- /box-settings-password -->

					</form><!-- /container-password-settings -->
					
					<div class="container-lkns">
					
						<a href="#" class="lkn-save">Save</a>

						<a href="#" class="lkn-cancel">Cancel</a>

					</div><!-- /container-lkns -->

				</div><!-- /container-settings -->

			</div><!-- /col -->
		
		</div><!-- /row -->
		
	</div><!-- /container-fluid -->

</main>	

<? include 'inc/footer.php'?>