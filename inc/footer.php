<footer id="footer">
    <div class="container-fluid no-padding">
        <div class="row">
            <div class="col-xs-12">
                <h4 class="logo-footer">
                    <img src="images/logo-footer.svg" alt="">
                </h4>
                <ul class="list-footer">
                    <li class="footer-li">
                        <a href="#" class="footer-link">+44 (0)20 8731 8988</a>
                    </li>
                    <li class="footer-li">
                        <a href="#" class="footer-link">admin@achisomoch.org</a>
                    </li>
                    <li class="footer-li">
                        <a href="#" class="footer-link">35 Templars Avenue, London NW11 0NU &nbsp; V <?php echo SYSTEM_VERSION ?></a>
                    </li>
                </ul>
                <ul class="list-footer-desktop hidden-xs">
                    <li class="footer-desktop-li">
                        <a href="help.php" class="transition external-lkn" href="#">HELP</a>
                    </li>
                    <li class="footer-desktop-li">
                        <a href="invite-a-friend.php" class="transition external-lkn" href="#">INVITE A FREIND</a>
                    </li>
                    <li class="footer-desktop-li">
                        <a href="contact-us.php" class="transition external-lkn" href="#">CONTACT US</a>
                    </li>
                </ul>
            </div><!-- /col -->
        </div><!-- /row -->
    </div><!-- /container -->
</footer>

<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<script type="text/javascript" src="js/bootstrap-select.js" ></script>
<script type="text/javascript" src="js/bootstrap-switch.js" ></script>
<script type="text/javascript" src="js/jquery.lettering.js" ></script>
<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/daterangepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-dialog.min.js" ></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/indexpage.js"></script>

		<link rel="stylesheet" href="css/jqueryui/cupertino/jquery-ui-1.10.4.custom.min.css" type="text/css" media="all" />

		<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>

<script language="javascript" src="js/request_validate.js"></script>

	<script>
    $(document).ready(function () {

		if(window.location.hash && window.location.hash.indexOf('index.php')==-1){
			var url = window.location.hash.substr(1);
			
			loadpage(url);
		}

		$('.autocomplete-charities').autocomplete({
			source: 'remote.php?m=getCharityList',
		    messages: {
		        noResults: '',
		        results: function() {}
		    },
			resultTextLocator:'label',
			select: function(event, ui){
				event.preventDefault();
				$('.autocomplete-charities').val(ui.item.name);

				/**
				if(ui.item.address!=''){
					$('#charityAddressBox').show();
					$('#charityAddressBoxData').html(ui.item.address);
				} else
					$('#charityAddressBox').hide();
				**/

				DoCharityChange();

			}
		});
	});		
	</script>

<script>
    Userback = window.Userback || {};
    Userback.access_token = '845|957|GnTf3VL0lmOsB9ZeYaRIiQx9tjIkWQACdtRhpDhL05dCfcRdnI';

    (function(id) {
        if (document.getElementById(id)) {return;}
        var s = document.createElement('script');
        s.id = id;
        s.src = 'https://static.userback.io/widget/v1.js';
        var parent_node = document.head || document.body;
        parent_node.appendChild(s);
    })('userback-sdk');
</script>

</body>
</html>