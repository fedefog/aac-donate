<script type="text/javascript">
    function clearOthers_m(current_element) {

        if ($('#chkTransactionId_m').parent().hasClass('active') === false && $('#chkTransactionId_m') !== $(current_element)) {
            $('#txtTransactionId_m').val('');
        }

        if ($('#chkCharityName_m').parent().hasClass('active') === false && $('#chkCharityName_m') != $(current_element)) {
            $('#txtCharityName_m').val('');
        }
        if ($('#chkAmount_m').parent().hasClass('active') === false && $('#chkAmount_m') != $(current_element)) {
            $('#txtAmount_m').val('');
        }
        if ($('#chkNotes_m').parent().hasClass('active') === false && $('#chkNotes_m') != $(current_element)) {
            $('#txtNotes_m').val('');
        }
        if ($('#chkVoucherNumber_m').parent().hasClass('active') === false && $('#chkVoucherNumber_m') != $(current_element)) {
            $('#txtVoucherNumber_m').val('');
        }
        if ($('#chkBookVoucherNumber_m').parent().hasClass('active') === false && $('#chkBookVoucherNumber_m') != $(current_element)) {
            $('#txtBookVoucherNumber_m').val('');
        }
        if ($('#chkType_m').parent().hasClass('active') === false && $('#chkType_m') != $(current_element)) {
            $('#txtType_m').val('');
        }
    }

    $('#chkTransactionId_m').click(function (event) {
        event.preventDefault( );

        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers_m(this);
    });
    $('#chkCharityName_m').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers_m(this);
    });
    $('#chkAmount_m').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers_m(this);
    });
    $('#chkNotes_m').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers_m(this);
    });
    $('#chkVoucherNumber_m').click(function (event) {
        event.preventDefault();
        if ($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers_m(this);
    });
    $('#chkBookVoucherNumber_m').click(function (event) {
        event.preventDefault();
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers_m(this);
    });
    $('#chkType_m').click(function (event) {
        event.preventDefault( );
        if ($(this).parent().hasClass('active') === true) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
        clearOthers_m(this);
    });
</script>
<!-- AACDESING -->
<div class="form-group">
    <label for="" class="label">TRANSACTION ID</label>
    <div class="row-input"> 
        <a href="javascript:void(0);" id="chkTransactionId_m" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
        <div class="mid-size container-input-search">
            <input type="text" id="txtTransactionId_m" class="input input-search" placeholder="For a specific transaction." name="transaction_id">
            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="" class="label">CHARITY NAME</label>
    <div class="row-input"> 
        <a href="javascript:void(0);" id="chkCharityName_m" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
        <div class="mid-size container-input-search">
            <input type="text" class="input input-search" id="txtCharityName_m" placeholder="Please enter the name of the charity" name="charity_name">
            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>

    </div>

</div>
<div class="form-group">
    <label for="" class="label">AMOUNT </label>
    <div class="row-input"> 
        <a href="javascript:void(0);" id="chkAmount_m" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
        <div class="mid-size container-input-search container-input-search-min">
            <input type="text" class=" input input-search" id="txtAmount" placeholder="Amount number" name='amount_donated' value="<?php echo $search['amount_donated'] ?>">
            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>

        <div class="mid-size container-to-amount">
                
            <input type="text" class="input input-to-amount" id="txtAmount" placeholder="TO" name='amount_donated' value="<?php echo $search['amount_donated'] ?>">

            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        
        </div>
    </div>
</div>
<div class="form-group">
    <label for="" class="label">PERSONAL NOTES</label>
    <div class="row-input"> 
        <a href="javascript:void(0);" id="chkNotes_m" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
        <div class="mid-size container-input-search">
            <input type="text" class="input input-search" id="txtNotes_m" placeholder="Search your personal notes" name='personal_note'>
            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="" class="label">VOUCHER NUMBER</label>
    <div class="row-input"> 
        <a href="javascript:void(0);" id="chkVoucherNumber_m" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
        <div class="mid-size container-input-search container-input-search-min">
            <input type="text" class="input input-search" id="txtVoucherNumber" placeholder="Voucher Number" name='voucher_no' value="<?php echo $search['voucher_no'] ?>">
            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
        <div class="mid-size container-to-amount">

            <input type="text" class=" input input-to-amount" id="txtVoucherNumber" placeholder="TO" name='voucher_no' value="<?php echo $search['voucher_no'] ?>">
            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="" class="label">DISPLAY VOUCHER BOOK</label>
    <div class="row-input"> 
        <a href="javascript:void(0);" id="chkBookVoucherNumber_m" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
        <div class="mid-size container-input-search">
            <input type="text" class="input input-search" id="txtBookVoucherNumber_m" placeholder="Enter a voucher number." name='book_voucher_no'>
            <a href="#" class="reset-input">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="" class="label">TRANSACTION TYPE</label>
    <div class="row-input"> 
        <a href="javascript:void(0);" id="chkType_m" class="checkbox-input"> <i class="fa fa-check" aria-hidden="true"></i> </a>
        <div class="mid-size container-input-search">
            <select id="txtType" class="input" name='transaction_type'>
                <option value="">Select...</option>
                <option value="">Select...</option>
                <option value="">Select...</option>
                <option value="">Select...</option>
                
            </select>
        </div>
    </div>

<!-- END AACDESING-->
</div>