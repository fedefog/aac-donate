<?php
$user = new User();
$user = User::GetInstance();
if ($_REQUEST['page']) {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

$transactionlist = new AACRequestList();

$transactionlist->filters[] = 'UserName="' . $user->Username . '" ';
$transactionlist->filters[] = 'Request IN ("New Voucher Book") ';
// AND ResultCode="Pending"


//$transactionlist->SetPage($page);

$vtl = $transactionlist->ListItems();
?>
<table class="table table-order-books table-condensed">
		<?php
		if(count($vtl)) {
		?>
        <thead> 
            <tr>
                <th>DATE</th>
                <th class="hidden-xs">REQUEST ID</th>
                <th>VOUCHER BOOK ORDERED</th>
                <th class="hidden-xs">AMOUNT</th>
                <th> ACTION</th>
                
            </tr>
        </thead>		
        <tbody>
		<?php
			foreach($vtl as $v) {
		?>				
            <tr class=" order-books-row">
                <td class="modal-show" data-toggle="modal" data-target="#modal-voucher" data-id="<?php echo $v->id ?>" data-type="RQ">
                    <a href="javascript:void(0);">
                        <div class="date"><?php echo date('d-m-y',$v->RequestDateTime) ?></div>
                    </a>
                </td>
                <td class="modal-show hidden-xs" data-toggle="modal" data-target="#modal-voucher" data-id="<?php echo $v->id ?>" data-type="RQ">
                    <a href="javascript:void(0);">
                        <span class="span-request-id">
                            
                                <?php echo $v->id ?>
                            
                        </span><!-- /desc-table -->
                    </a>
                </td>
                <td class="modal-show" data-toggle="modal" data-target="#modal-voucher" data-id="<?php echo $v->id ?>" data-type="RQ">
                    <a href="javascript:void(0);">
                       <span class="info-vocher-book-orderer"><?php echo $v->FormatSummary() ?>
						<?php if($v->ResultCode=="Pending") { ?>
                        <br>
                        <spam class="being-processed">CURRENTLY BEING PROCESSED</spam>
						<?php } ?>
                        </span>
                    </a>
                </td>
                <td class="modal-show amount-td hidden-xs" data-toggle="modal" data-target="#modal-voucher" data-id="<?php echo $v->id ?>" data-type="RQ">
                    <a href="javascript:void(0);">
                        <span class="amount">
                            <?php echo $v->FormatAmount() ?>
                        </span>
                    </a>
                </td>
                <td>
                <!-- AACDESIGN3 -->
                <a href="vouchers.php?id=<?php echo $v->id ?>&clone=1" class="refresh-transactions btn-trannsaction-accion ajaxlink" title="Redo this transaction"></a>
                </td>
                        
                        
            </tr>
			<?php
				}
			} else {
			?>
            
            <!--  EMPTY STATE -->
            
            <tr class="order-books-row hide">
                
                <td colspan="4">
                    
                    <div class="box-empty-state">
                            
                        <span class="title-empty-state">You have not yet ordered any voucher books.</span>

                        <a href="#" class="lkn-oreder-voucher">ORDER VOUCHER BOOKS</a>
                        
                    </div>
                    
                </td>

            </tr>


        </tbody>
			<?php
			}
			?>
    </table>        