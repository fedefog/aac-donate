jQuery(document).ready(function () {
    jQuery("#Beneficiary").keyup(function () {
        jQuery('#hidden_allow').val('0');
        var filter = jQuery(this).val().toLowerCase();
        jQuery(".results li").each(function () {
            var x = jQuery(this).text().toLowerCase();
            if (x.indexOf(filter) != -1) {
                jQuery(this).hide();
            } else {
                jQuery(this).hide();
            }
        });
    });
    jQuery(document).on('click', '.results li', function () {
       jQuery('#hidden_allow').val('1');
    });
    jQuery(document).on('click', '.dashboard-row, .transaction_all-row, .transaction_history-row, .pending-transaction-row, .standing-orders ', function () {
        var modal_data = jQuery(this).data('id');
        var modal_type = jQuery(this).data('type');
        //var row_arr = modal_data.split('||');

		if(typeof(modal_data)=='undefined') return;

		$('#modal-voucher .modal-body').html('loading...');
		
		$.ajax({
			url: 'remote.php?m=get-popup-dialog&id='+modal_data+'&dialog_type='+modal_type,
			type: 'post',
			dataType: 'html',
			data: null,
			success: function(data)
			{
				$('#modal-voucher .modal-body').html(data);
			}
		});

		/**
        if (modal_type == "VO" || modal_type == "NV"  || modal_type == "PEN" ) {
            jQuery('#vo_mdl_beneficiary').html('');
            jQuery('#vo_mdl_beneficiary').html(row_arr[1]);
            jQuery('#vo_mdl_dnt_amt').html('');
            jQuery('#vo_mdl_dnt_amt').html(row_arr[4]);
            jQuery('#vo_mdl_dt_prcd').html('');
            jQuery('#vo_mdl_dt_prcd').html(row_arr[2]);
            jQuery('#vo_mdl_vch_num').html('');
            jQuery('#vo_mdl_vch_num').html(row_arr[6]);
            jQuery("#lnk_vch_donate_again").attr('href', 'make-a-donation.php?charity_id=' + row_arr[11]);
        } else if (modal_type == "SO") {
            jQuery('#modal_beneficiary').html('');
            jQuery('#modal_beneficiary').html(row_arr[1]);
            jQuery('#modal_date_paid').html('');
            jQuery('#modal_date_paid').html(row_arr[2]);
            jQuery('#modal_amount').html('');
            jQuery('#modal_amount').html(row_arr[4]);
            jQuery('#modal_payments_number').html('');
            jQuery('#modal_payments_number').html(row_arr[7]);
            jQuery('#modal_notes_aac').html('');
            if (row_arr[9] == "") {
                jQuery('#modal_notes_aac').html("No Notes have been added");
            } else {
                jQuery('#modal_notes_aac').html(row_arr[9]);
            }
            jQuery('#modal_charity_notes').html('');
            if (row_arr[10] == "") {
                jQuery('#modal_charity_notes').html("No Notes have been added");
            } else {
                jQuery('#modal_charity_notes').html(row_arr[10]);
            }
            jQuery("#lnk_view_all").attr('href', 'standing-orders.php?charity_id=' + row_arr[11]);
        } else if (modal_type == "Cd" || modal_type == "Ch") {
            jQuery('#mdl_comp_name').html('');
            jQuery('#mdl_comp_name').html(row_arr[1]);
            jQuery('#mdl_amount').html('');
            jQuery('#mdl_amount').html(row_arr[4]);
            jQuery('#mdl_date').html('');
            jQuery('#mdl_date').html(row_arr[2]);
            jQuery("#lnk_donate_again").attr('href', 'make-a-donation.php?charity_id=' + row_arr[11]);
        }
		**/
    });
});
var currencyWarningShown = false;
var selectedCharityCountry = '<?php echo trim($RemoteCharityCountry) ?>';
//console.log(<?php echo NIS_EXRATE ?>);
//var NIS_exrate = <?php echo NIS_EXRATE ?>;
//var USD_exrate = <?php echo USD_EXRATE ?>;
//var EUR_exrate = <?php echo EUR_EXRATE ?>;
function DoCharityChange() {
    var charityName = $('#Beneficiary').val();
    $.ajax({
        dataType: 'json',
        url: 'remote.php?m=getCharityDetail&charityName=' + encodeURIComponent(charityName),
        success: function (data) {
            if (data.found == 1) {
                selectedCharityCountry = $.trim(data.countryName);
                    $('#charityRemoteID').val(data.remoteCharityID);
            }
        }
    });
    DoCurrencyList();
}
function DoCurrencyList() {
    var charityName = $('#Beneficiary').val();
    $.ajax({
        url: 'remote.php?m=getCurrencyCodes&charityName=' + encodeURIComponent(charityName),
        success: function (data) {
            if (data == '') {
                //jQuery('#Currency').html('<option value="GBP">GBP</option>');
                jQuery('.selectpicker').selectpicker('refresh');
            } else {
                jQuery('#Currency').html(data);
                jQuery('.selectpicker').selectpicker('refresh');
            }
        }
    });
}
function confirmTransfer() {
    if ($('.ConfirmTransfer').hasClass('active')) {
        document.getElementById("ConfirmTransfer").value = '';
    } else {
        document.getElementById("ConfirmTransfer").value = '1';
    }
}
function TestNumber(amount) {
    if (isNaN(amount)) {
        return false;
    }
    var arr = amount.split('.');
    if (arr.length == 2) {
        var length = arr[1].length;
        if (length > 2)
            return false;
    }
    return true;
}

function Validate(form) {
    var balance = '<?php echo $balance; ?>';
    if (!form.elements['fields[Amount]'])
        return true;
    var currency = $('#Currency').val();
    var amount = form.elements['fields[Amount]'].value;
    var beneficiary = $('#Beneficiary').val();
    var confirm = $('#ConfirmTransfer').val();
    if ($('#hidden_allow').val() == '' || $('#hidden_allow').val() == '0') {
        jQuery("#modal-quick-donation p").html('Please select charity from list');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    }
    if (beneficiary == '' || beneficiary == 'Please select charity from list') {
        //alert('Please select a Beneficiary');
        jQuery("#modal-quick-donation p").html('Please select a Beneficiary');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    }
    if (amount == '') {
        //alert("Please enter a Amount");
        jQuery("#modal-quick-donation p").html('Please enter a Amount');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    }
    if (!TestNumber(amount)) {
        //alert('Amount should be a number without any formatting, e.g. 200 or 200.99');
        jQuery("#modal-quick-donation p").html('Amount should be a number without any formatting, e.g. 200 or 200.99');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    }
    var neg = parseFloat(amount) < 0;
    var gbpamount = amount;
    if (confirm != 1) {
        //alert('Please confirm the transaction is charitable');
        jQuery("#modal-quick-donation p").html('Please confirm the transaction is charitable');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    }
    if (currency == 'NIS')
        gbpamount = gbpamount / NIS_exrate;
    if (currency == 'USD')
        gbpamount = gbpamount / USD_exrate;
    if (currency == 'EUR')
        gbpamount = gbpamount / EUR_exrate;
    console.log(2);
    if (selectedCharityCountry == null)
        selectedCharityCountry = '';
    selectedCharityCountry = $.trim(selectedCharityCountry.toUpperCase());
    if (selectedCharityCountry == '')
        selectedCharityCountry = 'UK';
    if (selectedCharityCountry == 'ISRAEL') {
        BootstrapDialog.show({
            message: 'Please note ' + "\u00a3" + '4 will be deducted for bank charges',
            buttons: [{
                    label: 'Cancel',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }, {
                    label: 'Confirm',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        dialogItself.close();
                        jQuery("#quick-donation").submit();
                    }
                }]
        });
        /*if (!window.confirm('Please note ' + "\u00a3" + '4 will be deducted for bank charges'))
         return false;*/
    } else if (selectedCharityCountry == 'USA') {
        BootstrapDialog.show({
            message: 'Please note ' + "\u00a3" + '15 will be deducted for bank charges',
            buttons: [{
                    label: 'Confirm',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        dialogItself.close();
                        jQuery("#quick-donation").submit();
                    }
                }, {
                    label: 'Cancel',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
        /*if (!window.confirm('Please note ' + "\u00a3" + '15 will be deducted for bank charges'))
         return false;*/
    } else if (selectedCharityCountry == 'FRANCE' || selectedCharityCountry == 'GERMANY' || selectedCharityCountry == 'BELGIUM' || selectedCharityCountry == 'ITALY') {
        BootstrapDialog.show({
            message: 'Please note ' + "\u00a3" + '5 will be deducted for bank charges',
            buttons: [{
                    label: 'Confirm',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        dialogItself.close();
                        jQuery("#quick-donation").submit();
                    }
                }, {
                    label: 'Cancel',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    }
    if ($('#ClientComments').val().toLowerCase().indexOf("raffle", 0) > -1) {
        //alert('You cannot pay for raffles with AAC funds');
        jQuery("#modal-quick-donation p").html('You cannot pay for raffles with AAC funds');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    } else if (!neg && (parseFloat(gbpamount) < 10) && (selectedCharityCountry == 'UK')) {
        //alert('Sorry, this system can only be used to transfer ' + "\u00a3" + '10 or more - please try again');
        jQuery("#modal-quick-donation p").html('Sorry, this system can only be used to transfer ' + "\u00a3" + '10 or more - please try again');
        jQuery("#modal-quick-donation").modal('show');
        return false;
        //} else if (so && (currency != 'GBP')) {
    } else if ((selectedCharityCountry != 'UK') && (parseFloat(gbpamount) < 50)) {
        //alert('Sorry, transfers to charities abroad must be ' + "\u00a3" + '50 or more');
        jQuery("#modal-quick-donation p").html('Sorry, transfers to charities abroad must be ' + "\u00a3" + '50 or more');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    } else if (neg && (parseFloat(gbpamount) >= -18) && (parseFloat(gbpamount) < 0)) {
        //alert('Sorry, this system can only be used to transfer ' + "\u00a3" + '18 or more- please try again');
        jQuery("#modal-quick-donation p").html('Sorry, this system can only be used to transfer ' + "\u00a3" + '18 or more- please try again');
        jQuery("#modal-quick-donation").modal('show');
        return false;
    } else if (balance != '' && (parseFloat(gbpamount) > parseFloat(balance))) {
        BootstrapDialog.show({
            message: 'Your account balance is insufficient for this transaction, would you like to proceed?',
            buttons: [{
                    label: 'Confirm',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        dialogItself.close();
                        jQuery("#quick-donation").submit();
                    }
                }, {
                    label: 'Cancel',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    }
    BootstrapDialog.show({
        message: 'You have selected to donate ' + currency + ' ' + gbpamount + ' to ' + beneficiary + '. Please confirm your donation.',
        buttons: [{
                label: 'Confirm',
                cssClass: 'btn-primary',
                action: function (dialogItself) {
                    //dialogItself.close();
                    jQuery("#quick-donation").submit();
                }
            }, {
                label: 'Cancel',
                action: function (dialogItself) {
                    dialogItself.close();
                }
            }]
    });
    return false;
}