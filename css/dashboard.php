<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'cls/vouchers.cls.php';
require_once 'cls/charities.cls.php';
require_once 'cls/ui.cls.php';
require_once 'cls/aac_requests.cls.php';
require_once 'cls/sendmail.cls.php';
require_once 'cls/class.smtp.php';
require_once 'cls/class.phpmailer.php';
require_once 'cls/emails.cls.php';
require_once 'cls/emaillog.cls.php';
require_once 'inc/funcs.inc.php';
//require_once 'inc/domit/xml_domit_include.php';
session_start();
User::LoginCheck();

$user = new User();
$user = User::GetInstance();
$td = new TransactionDetailList();
$transaction = $td->getTransactionDetailByAccountName($user->Reference);

foreach ($transaction as $tr) {
    $balance = $tr->Close_balance;
    $account = $tr->Reference;
    $lastStatementDate = $tr->Last_statement_date;
    $date = date('d M Y, H:iA', strtotime($tr->Last_statement_date));
}
$request = new AACRequestItem();
if ($_REQUEST['Request']) {
    $fields['Request'] = $_REQUEST['Request'];
} else {
    $fields = $_REQUEST;
    $fields['Request'] = 'Initiate Transfer';
}
if ($_POST['doAction']) {
    $fields = $_REQUEST['fields'];
    $error = '';
    $fields[StandingOrderFrequency] = "No";
    $options = array(date('Y-m-1') => date('M Y'));
    $t = strtotime("+{1} months", strtotime(date('Y-m-1')));
    $options[date('Y-m-1', $t)] = date('M Y', $t);
    $fields['StandingOrderStartDate'] = current($options);
    switch ($fields['Request']) {
        case 'Initiate Transfer':
            $fields['Amount'] = abs($fields['Amount']);
            if (!$fields['Beneficiary'] || $fields['Beneficiary'] == 'Please select charity from list')
                $error = 'Please select a Beneficiary';
            else if (!$fields['Amount'])
                $error = 'Please enter an amount';
            else if (!is_numeric($fields['Amount']))
                $error = 'Amount must be a number';
            else if (!$_REQUEST['ConfirmTransfer'])
                $error = 'Please confirm the transaction is charitable';
            $NIS_exrate = NIS_EXRATE;
            $USD_exrate = USD_EXRATE;
            $EUR_exrate = EUR_EXRATE;
            $gbpAmount = 0;
            if ($fields['Currency'] == 'GBP' || !$fields['Currency'] || !$fields['Amount']) {
                
            } else if ($fields['Currency'] == 'EUR') {
                $gbpAmount = $fields['Amount'] / $EUR_exrate;
            } else if ($fields['Currency'] == 'USD') {
                $gbpAmount = $fields['Amount'] / $USD_exrate;
            } else if ($fields['Currency'] == 'NIS') {
                $gbpAmount = $fields['Amount'] / $NIS_exrate;
            }
            if ($_REQUEST['charityRemoteID']) {
                $fields['RemoteCharityID'] = $_REQUEST['charityRemoteID'];
                $charity = new CharityItem();
                if ($charity->LoadByColumnName($fields['Beneficiary'], 'Name')) {
                    $RemoteCharityCountry = $charity->CountryName;
                }
            } else {
                $charity = new CharityItem();
                if ($charity->LoadByColumnName($fields['Beneficiary'], 'Name')) {
                    $fields['RemoteCharityID'] = $charity->remote_charity_id;
                    $RemoteCharityCountry = $charity->CountryName;
                } else
                    $fields['RemoteCharityID'] = -2;
            }
            if ($RemoteCharityCountry && (strtoupper(trim($RemoteCharityCountry)) != 'UK'))
                $fields['OfficeComments'] .= "\nCountry: " . $RemoteCharityCountry;
            if ($gbpAmount) {
                $gbpAmount = round($gbpAmount, 2);
                $gbpAmountF = number_format($gbpAmount, 2);
                $fields['OfficeComments'] .= "\nEstimated GBP Amount " . utf8_decode('�') . $gbpAmountF;
                $fields['GBPAmount'] = $gbpAmount;
            } else
                $fields['GBPAmount'] = $fields['Amount'];
            $fields['OfficeComments'] = trim($fields['OfficeComments'], "\n");
            break;
    }

    if (!$error) {
        $request->Username = $user->Username;
        if (!$id) {
            $request->ResultCode = 'Pending';
            $request->RequestDateTime = time();
        }
        if ($fields['VoucherBooks'] && is_array($fields['VoucherBooks']) && count($fields['VoucherBooks'])) {
            $vb = '';
            foreach ($fields['VoucherBooks'] as $vbook => $qty) {
                if (!$qty)
                    continue;
                $vbook = utf8_decode(html_entity_decode($vbook));
                $vb .= "{$qty}x{$vbook}; ";
            }
            $fields['VoucherBooks'] = trim($vb, ' ;');
        }
        $fields['StandingOrderStartDate'] = $fields['StandingOrderStartDate'] ? strtotime($fields['StandingOrderStartDate']) + 3600 : '0';
        $fields['StandingOrderEndDate'] = $fields['StandingOrderEndDate'] ? intval($fields['StandingOrderEndDate']) + 3600 : '0';
        $fields['System'] = 'Desktop';
        $request->SetProperties($fields);
        $request->UpdateSummary();
        $request->VoucherBookUrgent = $request->VoucherBookUrgent ? 'Yes' : 'No';
        $request->Save();
        UI::Redirect('index.php');
        $details = "Request: " . $fields['Request'];
        if ($_POST['clone'])
            $details .= ' : Re-Request';
        User::LogAccessRequest($user->Username, '', $details);
        $x['done'] = true;
    }
} else if (!$_REQUEST['done'] && !$id) {
    $details = "New Request: " . $fields['Request'];
    User::LogAccessRequest($user->Username, '', $details);
}
switch ($fields['Request']) {
    case 'Initiate Transfer':
        $field_list = array('BeneficiaryField', 'AmountField', 'StandingOrderField');
        break;
    default:
        die('Unknown request');
        $field_list = array();
}
?>
<?php if ($x['done']) { ?>
    <p class="blue-text" style="margin: 0 15%;">Your request has been sent. <a href="index.php">Return to request Main Page.</a></p>
    <div style="height:150px"></div>
    <?php
    exit;
} else {
    ?>
    <main id="dashboard" class="content-desktop">
        <div class="dashboard-desktop container-fluid hidden-xs">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="top-content">
                        <?php
                        $qry = "";
                        $qry .= " SELECT * FROM users";
                        $qry .= " WHERE id = " . $user->id;
                        $result = mysql_query($qry);
                        $row_user = mysql_fetch_row($result, MYSQL_ASSOC);
                        if ($row_user['ShowUserDisplayName'] == "1") {
                            echo '<h1>Welcome to your account, ' . $user->UserDisplayName . '</h1>';
                        } else {
                            echo '<h1>Welcome to your account.</h1>';
                        }
                        ?>
                        <div class="date pull-right"><?php echo date('l d M Y, H:iA'); ?></div>
                    </div>
                    <div class="line"></div>
                </div><!-- col 12 -->
            </div>
            <div class="row">
                <div class="col-md-7">

                    <!-- AACDESING -->
                    <h2 class="title-dashborad-desktop title-dashborad-left">Latest Transactions</h2>

                    <a href="#" class="lkn-being-processed"><span class="number-notification">2</span>being processed</a>
                    <a href="#" class="lkn-pendings"><span class="number-notification">4</span> PENDING</a>
                    
                    <!-- END AACDESING -->
                    <?php
                    /* $transactionlist = new TransactionList();
                      $tl = $transactionlist->getDashTransactionListByUserName(intval($user->id)); */

                    $transactionlist = new TransactionList();
                    $transactionlist->sortby = 'DateTime';
                    $transactionlist->sortorder = 'desc';
                    $tl = $transactionlist->ListItems('UserName="' . intval($user->id) . '"');

                    if (count($tl) < 1) {
                        ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="empty-state">
                                        <p>Sorry, there are no results to display.</p>
                                        <ul>
                                            <li>Check your spelling, dates, or figures</li>
                                            <li>Try a different search tool</li>
                                        </ul>
                                        <span>OR</span>
                                        <a href="" class="empty-action">Get in touch with us</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <table class="table-transactions table table-condensed">
                            <thead> 
                                <tr>
                                    <th>DATE</th>
                                    <th>DESCRIPTION</th>
                                    <th>AMOUNT</th>
                                    <th>TYPE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($tl) {
                                    $k = 0;
                                    $j = count($tl);
                                    // $lastRowDate = '';
                                    //for ($i = $j - 1; $i >= 0; $i--) {
                                    //for ($i = 0; $i < $j; $i++) {
                                    foreach ($tl as $t) {
                                        $data = "";
                                        $rowDate = date('j-n-y', strtotime($t->DateTime));
                                        //$rowDate = date('d-n', strtotime($tl[$i]->DateTime));
                                        $status = "";
                                        if ($t->status == "0") {
                                            //$status = "Currently being processed";
                                            $status = "Pending";
                                        }
                                        $trans_type = $t->description;
                                        $rowtype = $t->CDNo;
                                        $amt = $t->Amount;
                                        $result_code = $t->ResultCode;
                                        if ($result_code == "Pending") {
                                            $result_code = "PENDING";
                                        }
                                        if ($rowtype == "VO") {
                                            $modal_name = "#modal-voucher";
                                        } else if ($rowtype == "SO") {
                                            $modal_name = "#modal-standing-order-donation";
                                        } else if ($rowtype == "Cd" || $rowtype == "Ch") {
                                            $modal_name = "#modal-company-donation";
                                        } else {
                                            $modal_name = "";
                                        }

                                        //echo "ID : ".$tl[$i]->id."<br>";

                                        $data .= $t->id . "||";
                                        $data .= $t->Name . "||";
                                        $data .= date('j-n-Y', strtotime($t->DateTime)) . "||";
                                        //$data .= date_create_from_format('Y-m-d', $tl[$i]->DateTime)->format('j-n-Y') . "||";
                                        $data .= date('j-n-Y', $t->RequestDateTime) . "||";
                                        $data .= showBalance(abs($t->Amount)) . "||";
                                        $data .= showBalance($t->Request_Amount) . "||";
                                        $data .= $t->Voucher . "||";
                                        $data .= $t->PaymentNumber . "||";
                                        $data .= $t->StandingOrderStartDate . "||";
                                        $data .= $t->ClientComments . "||";
                                        $data .= $t->OfficeComments . "||";
                                        $data .= $t->CharityNumber . "||";
                                        ?>
                                        <tr class="<?php echo getBalanceColor(number_format($amt, 2)); ?> modal-show dashboard-row" data-toggle="modal" data-target="<?php echo $modal_name; ?>" data-id="<?php echo $data; ?>" data-type="<?php echo $rowtype; ?>">
                                            <td>
                                                <a href="javascript:void(0);">
                                                    <div class="date"><?php echo $rowDate; ?></div>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);">
                                                    <div class="desc-table">
                                                        <h2 class="title"><?php echo $t->Description; ?></h2>
                                                        <h3 class="subtitle transaction-type-label"><?php echo $status; ?></h3>
                                                    </div><!-- /desc-table -->
                                                </a>
                                            </td>
                                            <td class="amount-td" >
                                                <a href="javascript:void(0);">
                                                    <span class="balance-transition voucher-balance">
                                                        <!--£ <?php //echo number_format($amt, 2);                               ?>-->
                                                        <?php echo showBalance($amt); ?>
                                                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="type-td transaction-type-label">
                                                <p class="type-transactions"><?php echo $trans_type; ?></p>
                                                <?php /* <p class="type-transactions"><?php echo getTransactionType($rowtype); ?></p> */ ?>
                                            </td>
                                    <input type="hidden" name="vchnumber" class="vch-number" value="<?php echo $t->Voucher; ?>">
                                    </tr>
                                    <?php
                                    $k++;
                                    if ($k == 10)
                                        break;
                                }
                            } /* else {
                              echo '<tr>';
                              echo '<td colspan="4" align="center"><h3>No Result Found.</h3><td>';
                              echo '<tr>';
                              } */
                            ?>
                            </tbody>
                        </table>
                        <a href="transactions.php" class="btn btn-primary view-more-transactions transition external-lkn">View More Transactions</a>
                        <?php
                    }
                    ?>
                </div><!-- col 6 -->

                <?php
                $notificationList = new NotificationList();
                $notificationItems = $notificationList->getNotificationByDate();
                $title = $notificationItems[0]->title;
                $post_date = date_create_from_format('Y-m-d', $notificationItems[0]->post_date)->format('M-d');
                $content = $notificationItems[0]->content;
                $url = $notificationItems[0]->url;
                ?>

                <div class="col-md-5">

                    <h2 class="title-dashborad-desktop" >Latest Updates</h2>

                    <div class="latest-update-desktop">
                        <div class="update-title"><strong><?php echo $post_date; ?></strong><?php echo $title; ?> UPDATE</div>
                        <p><?php echo $content; ?>&nbsp;<a href="<?php echo $url; ?>" target="_blank">READ MORE</a></p>
                    </div>

                    <h2 class="title-dashborad-desktop">Quick Donation</h2>
                    <?php if ($error) { ?>
                        <tr>
                            <td class="error" colspan="2" style="padding-bottom:10px;text-align:center"><?php echo $error ?></td>
                        </tr>
                    <?php } ?>
                    <form id="editor" class="make-donation search" name="editor"  method="post" action="<?php echo basename($_SERVER['PHP_SELF']); ?>">
						
                        <input class="input-beneficiary autocomplete-charities form-control input-text box-beneficiary" type="text" id="Beneficiary" name="fields[Beneficiary]" placeholder="Please select a Beneficiary" autocomplete="false" />
						<?php /**
                        <div class="search" id="search">
                            <span class="input-beneficiary caret" style="cursor:pointer;"></span>
                            <input class="input-beneficiary" type="text" id="Beneficiary" name="fields[Beneficiary]" placeholder="Please select a Beneficiary" autocomplete="false" />
                            <ul class="results">
                                <?php
                                $cl = new CharityList();
                                $charities = $cl->ListItems();
                                if (count($charities)) {
                                    foreach ($charities as $c) {
                                        ?>
                                        <li class="charity"><a href="#"><span><?php echo $c->Name; ?></span><br/></a></li>
                                        <?php
                                        // <li><a href="#"><span>GGBH</span><br />The Riding London NW11 8HL</a></li>
                                    }
                                }
                                ?>
                            </ul>
                        </div>
						**/ ?>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <div class="row">
                                <div class="col-md-6 col-lg-8">
                                    <input type="text" name="fields[Amount]" id="Amount" class="form-control input-text" placeholder="Enter an amount" >
                                </div>
                                <div class="col-md-6 col-lg-4 ">
                                    <?php
                                    //$options = array('GBP','Shekels','Dollars','Euros');
                                    $options = array();
                                    if ($request->id) {
                                        $beneficiary = $request->Beneficiary;
                                    } else if (is_array($charities)) {
                                        $c = reset($charities);
                                        $beneficiary = $c->Name;
                                    } else
                                        $beneficiary = '';

                                    if ($beneficiary) {
                                        $ccl = new CharityCurrencyList();
                                        $ccl_items = $ccl->GetCurrencyCodesByCurrencyName($beneficiary);
                                        if (count($ccl_items))
                                            foreach ($ccl_items as $i)
                                                $options[] = $i->CurrencyCode;
                                    } else {
                                        $options[] = 'GBP';
                                    }
                                    ?>
                                    <!--remove 'selectpicker' class to display currency's list. -->
                                    <select name="fields[Currency]" id="Currency" class="form-control" style="height:42px;">
                                        <?php
                                        /* <option value="GBP">GBP</option>
                                          <option value="USD">USD</option>
                                          <option value="EUR">EUR</option>
                                          <option value="NIS">NIS</option>
                                         */
                                        foreach ($options as $op) {
                                            ?>
                                            <option value="<?php echo $op; ?>"><?php echo $op; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <?php /* <select class="form-control selectpicker">
                                      <option>USD</option>
                                      <option>GBP</option>
                                      <option>£</option>
                                      </select>
                                     */ ?> 
                                </div>
                            </div>
                        </div>
                                <p class="text-danger amount-input-error">Please note that payments for under £100 may take longer to process.</p>
                                <p class="text-danger donations-are-subject-error">All donations are subject to compliance checks. Given the size of this donation, it is more likely to be selected for a random check. Please be aware that our Compliance Officer may be in touch with you to determine more information about this donation</p>
                                <p class="text-danger confirmation-amount">For your own safety please re-enter the amount you wish to donate </p>
                                <input type="text" name="confirmAmount" id="confirmAmount" class="form-control confirmation-amount input-text" placeholder="Please re-enter the amount you wish to donate">
                                <p class="text-danger confirmation-amount">In order to comply with money laundering  regulations,  this donation will also be eligible for random checks by our Compliance Officer. Please provide us a few sentences to outline the purpose of the donation to determine if we need to be in touch for more information. </p>
                                <input type="text" id="donationPurpose" name="donationPurpose" class="form-control confirmation-amount input-text" placeholder="Please enter the purpose of your donation">
                                <p class="text-danger confirmation-amount-error">This figure does not match the original amount.</p>
                        <div class="form-group">
                            <a class="add-notes more-note" href="#"> +  ADD NOTES TO CHARITY</a>
                            <a class="add-notes less-note" href="#"> - ADD NOTES TO CHARITY</a>
                        </div><!-- / form group -->
                        <div class="form-group">
                            <div class="box-notes">
                                <div class="box-make-donation ">
                                    <label >NOTES TO CHARITY</label>
                                    <textarea id="ClientComments" name="fields[ClientComments]" cols = "30" rows = "10" class = "textarea-make-dontation" placeholder = "Add any notes you'd wish to pass on the charity."></textarea>
                                    <p class="error error-text">Regrettably, we cannot make this payment since you may not use charitable funds to pay for a Raffle or tuition fees for your family. Please contact the office on 8731 8988 for further information” and reject the donation</p>
                                </div><!-- /box-make-donation -->
                                <div class="box-make-donation">
                                    <label >NOTES TO AAC</label>
                                    <textarea id="OfficeComments" name="fields[OfficeComments]" cols = "30" rows = "10" class = "textarea-make-dontation" placeholder = "Add any notes you'd wish to pass on to AAC."></textarea>
                                    <p class="error error-text">Regrettably, we cannot make this payment since you may not use charitable funds to pay for a Raffle or tuition fees for your family. Please contact the office on 8731 8988 for further information” and reject the donation</p>
                                </div><!-- /box-make-donation -->
                                <div class="box-make-donation">
                                    <label >MY NOTES</label>
                                    <textarea id="UserComments" name="fields[UserComments]" cols = "30" rows = "10" class = "textarea-make-dontation" placeholder = "Add any notes for your personal record keeping. These notes are searchable."></textarea>
                                    <p class="error error-text">Regrettably, we cannot make this payment since you may not use charitable funds to pay for a Raffle or tuition fees for your family. Please contact the office on 8731 8988 for further information” and reject the donation</p>
                                </div><!-- /box-make-donation -->
                            </div><!-- /form-group -->
                        </div><!-- box-notes -->
                        <div class="form-group checkbox-box">
                            <a href = "#" class = "ckeckbox ConfirmTransfer" onclick="confirmTransfer()" name="Confirm">
                                <span class="circle"></span>
                                <span class="text">
                                    I confirm that this donation is for charitable purposes only, I will not benefit directly or indirectly by way of goods or services from the donation.
                                </span>
                            </a>
                        </div>
                        <button type="submit" id="btnMakePayment" class="btn btn-make-a-donation transition">Make a Payment</button>
                        <input type="hidden" name="ConfirmTransfer" id="ConfirmTransfer"/>
                        <input type="hidden" id="hidden_allow" name="hidden_allow" value=""/>
                        <input type="hidden" name="fields[Request]" value="<?php echo $fields['Request']; ?>"/>
                        <input type="hidden" name="doAction" value="save" />

                        <input type="hidden" name="fields[RemoteCharityID]" value="<?php echo $fields['RemoteCharityID'] ?>" id="charityRemoteID" />
                        <input type="hidden" class="confirmation-box" name="confirm-transdetails" value="0" id="confirm-transdetails" />
                        <input type="hidden" class="confirmation-box" name="confirm-insufficiantbalance" value="0" id="confirm-insufficiantbalance" />
                        <input type="hidden" class="confirmation-box" name="confirm-bankcharges" value="0" id="confirm-bankcharges" />
                        <input type="hidden" class="confirmation-box" name="confirm-compliancemed" value="0" id="confirm-compliancemed" />


						<?php if($_REQUEST['doAction']=='clone') { ?>
                            <input type="hidden" name="clone" value="1" />
						<?php } ?>
						<input type="hidden" name="office-comment-option" id="office-comment-option" value="<?php echo $_REQUEST['office-comment-option'] ?>" />
                    </form>
                </div><!-- col 6 -->
            </div>
        </div><!-- /content-desktop-dashboard -->
        <div class="header-fixed visible-xs" >
            <header class="header ">
                <div class="container ">
                    <div class="row">
                        <?php
                        $sql = "";
                        $sql .= "SELECT t.*, c.Name, a.Beneficiary, a.Request, a.Summary, a.RequestDateTime, a.VoucherBooks, a.VoucherBookUrgent,
                        a.Currency, a.Amount as 'Request_Amount', a.ResultCode, a.ClientComments, a.OfficeComments,
                        a.UserComments, a.StandingOrderFrequency, a.StandingOrderStartDate, a.StandingOrderEndDate ";
                        $sql .= "FROM transaction t ";
                        $sql .= "LEFT JOIN aac_requests a on a.id = t.RequestId ";
                        $sql .= "LEFT JOIN charities c on c.remote_charity_id = t.CharityNumber ";
                        $sql .= "LEFT JOIN users u on u.Username = t.Username ";
                        $sql .= "WHERE t.Username = '" . $user->Username . "' AND a.ResultCode = 'Pending' ";
                        $result = mysql_query($sql) or die(mysql_error());
                        ?>
                        <a href="transactions-pending.php" title="Pending Transactions" class="pending-bt">
                            <img src="images/pending-icon.png" width="21" height="21">
                            <span class="badge"><?php echo mysql_num_rows($result); ?></span>
                        </a>
                        <div class="col-md-4">
                            <h1 class="logo-header">
                                <a href="#">
                                    <img src="images/logo-aac.svg" alt="">
                                </a>
                            </h1>
                        </div><!-- /col -->
                        <div class="col-md-4">
                            <?php
                            if ($row_user['ShowUserDisplayName'] == "1") {
                                echo '<h2 class="title-welcome">Welcome to your account, ' . $user->UserDisplayName . '</h2>';
                            } else {
                                echo '<h2>Welcome to your account.</h2>';
                            }
                            ?>
                            </h2>
                            <div class="box-account-header">
                                <div class="box-account">
                                    <h2 class="title">ACCOUNT</h2> 
                                    <h3 class="account-number"><?php echo $account; ?></h3>
                                </div><!-- /box-account -->
                                <div class="box-balance">
                                    <h2 class="title">BALANCE</h2>
                                    <h3 class="balance-number">£ <?php echo $balance; ?></h3>
                                </div><!-- /box-balance -->
                            </div><!-- /box-account-header -->
                            <h3 class="time">AS OF <strong><?php echo $date; ?></strong></h3>
                        </div><!-- /col -->
                        <a href="#" class="nav-mobile nav-icon4 visible-xs ">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    </div><!-- /row  -->
                </div><!-- /container  -->
            </header>
        </div><!-- /header-fixed -->
        <div class="container-fluid content-nav-mobile visible-xs ">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-daily-updates visible-xs">
                        <a href="#" class="lkn-daily daily-dashboard"> 
                            <span class="date">SEP-14 </span>  ROSH HASHANAH UPDATE 
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                            <i class="fa fa-angle-up" aria-hidden="true"></i>
                        </a>
                        <p class="text">The office will be closed Monday September 21 to Thursday the 24th. Please ensure all transactions are dealt with as soon as possible to avoid any issues given the high demand. Wishing everyone a ksiva v'chasima tova.</p>
                    </div><!-- /box-daily-updates -->
                    <ul class="nav-dashboard">
                        <li class="dashboard-li">
                            <a href="transactions.php" class="lkn-dashboard">
                                <span class="icon">
                                    <img src="images/view-transactions-icon.png" width="18" height="23">
                                </span>
                                <span class="text">View Transactions </span>
                                <div class="box-notification-nav">
                                    <span class="notification-nav"> 2 being processed </span>
                                    <span class="notification-nav">2 being processed </span>
                                </div>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="dashboard-li">
                            <a href="make-a-donation.php" class="lkn-dashboard">
                                <span class="icon">
                                    <img src="images/make-donation-icon.png" width="23" height="27">
                                </span>
                                <span class="text">Make a Donation </span>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="dashboard-li">
                            <a href="standing-orders.php" class="lkn-dashboard">
                                <span class="icon">
                                    <img src="images/standing-orders-icon.png" width="18" height="30.5">
                                </span>
                                <span class="text">Standing orders </span>
                                <i class="fa fa-angle-right" aria-hidden="true">
                                </i>
                            </a>
                        </li>
                        <li class="dashboard-li">
                            <a href="vouchers.php" class="lkn-dashboard">
                                <span class="icon">
                                    <img src="images/order-voucher-icon.png" width="24.5" height="20.5">
                                </span>
                                <span class="text">Order Vouchers Books</span>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div><!-- /col -->
            </div><!-- /row -->
        </div><!-- /container-fluid -->
    </main>
    <?php
}
?>