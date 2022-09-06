
<style type="text/css">.ui-tooltip, .arrow:before {background: #5BA4A4;border:1px #fff solid !important;}.ui-tooltip {padding: 10px 10px;color: white;font: bold 13px "Helvetica Neue", Sans-Serif;}.arrow {width: 70px;height: 25px;overflow: hidden;position: absolute;bottom: 5px;left: -26px;z-index: -1;}.arrow{display:none !important;}.arrow:before {content: "";position: absolute;left: 20px;top: 0px;width: 25px;height: 25px;-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);tranform: rotate(45deg);}</style>

<?php
$event_name = $oEvent->event_name;
$event_id = $oEvent->id;

$form_url = $this->adminUrl('admin_payments/edit', array('event_id' => $event_id, 'id' => $payment_id));

$payer_id = $row['payer_id'];
$payment_date = $row['payment_date'];
$txn_id = $row['txn_id'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$payer_email = $row['payer_email'];
$payer_status = $row['payer_status'];
$payment_type = $row['payment_type'];
$memo = $row['memo'];
$item_name = $row['item_name'];
$item_number = $row['item_number'];
$quantity = $row['quantity'];
$mc_gross = $row['mc_gross'];
$mc_currency = $row['mc_currency'];
$address_name = $row['address_name'];
$address_street = $row['address_street'];
$address_city = $row['address_city'];
$address_state = $row['address_state'];
$address_zip = $row['address_zip'];
$address_country = $row['address_country'];
$address_status = $row['address_status'];
$payer_business_name = $row['payer_business_name'];
$payment_status = $row['payment_status'];
$pending_reason = $row['pending_reason'];
$reason_code = $row['reason_code'];
$txn_type = $row['txn_type'];

$today = date("Y-m-d");

$sql = "SELECT * FROM " . get_option('evr_attendee') . " WHERE id = '" . (int) $payer_id . "' LIMIT 1";

$result = $this->wpDb()->get_results($sql, ARRAY_A);
foreach ($result as $row) {
    $id = $row ['id'];
    $attendee_id = $row ['id'];
    $lname = $row ['lname'];
    $fname = $row ['fname'];
    $address = $row ['address'];
    $city = $row ['city'];
    $state = $row ['state'];
    $zip = $row ['zip'];
    $email = $row ['email'];
    $phone = $row ['phone'];
    $event_id = $row ['event_id'];
    $num_people = $row['quantity'];
    $coupon = $row['coupon'];
    $payment = $row['payment'];
}

$sql = "SELECT * FROM " . get_option('evr_event') . " WHERE id='" . (int) $event_id . "' LIMIT 1";
$result = $this->wpDb()->get_results($sql, ARRAY_A);
foreach ($result as $row) {
    $event_id = $row ['id'];
    $event_name = $row ['event_name'];
    $event_desc = $row ['event_desc'];
    $event_description = $row ['event_desc'];
    $identifier = $row ['event_identifier'];
    $coupon_code = $row['coupon_code'];
    $use_coupon = $row['use_coupon'];
    $coupon_code_price = $row['coupon_code_price'];
    $active = $row ['is_active'];
}




$sql2 = "SELECT SUM(mc_gross) FROM " . get_option('evr_payment') . " WHERE payment_status = 'success' AND payer_id='$attendee_id'";
$result2 = $this->wpDb()->get_results($sql2, ARRAY_A);
foreach ($result2 as $row) {
    $total_paid = $row['SUM(mc_gross)'];
}

if ($use_coupon == "Y" && $event_cost > "0") {
    if ($coupon == $coupon_code) {
        $discount = $coupon_code_price;
    } else {
        $discount = "0";
    }
}

if ($payment > "0") {
    $balance = ($payment - $total_paid);
    $balance = EventPlus_Helpers_Funx::moneyFormat($balance);
} else if ($event_cost == "") {
    $balance = "Free Event";
} else {
    $balance = "Free Event";
}
?>

<br />
<div class="wrap">
    <div id="dashboard-widgets-wrap">
        <div id="dashboard-widgets" class="metabox-holder">
            <div class='postbox-container' style='width:auto;'>
                <div id='normal-sortables' class='meta-box-sortables'>
                    <div id="dashboard_right_now" class="postbox ">
                        <h3>

                            <span><?php echo $form_heading; ?> <?php echo "  " . $fname . " " . $lname . " " . $email . "    "; ?></span>


                        </h3>
                        <p class="bal"><?php
                            _e('Balance Owed:', 'evrplus_language');
                            echo "  " . $balance;
                            ?></p>

                        <div class="inside">
                            <div class="padding">


                                <ul class="po">
                                    <form method="post" action="<?php echo $form_url; ?>">


                                        <li>
                                            <div class="pass1"><label><?php _e('Payment Received Date', 'evrplus_language'); ?></label></div>
                                            <div class="pass2"> <input type="text" name="payment_date" size="15" value="<?php echo $payment_date; ?>"/></div>
                                        </li>
                                        <li>
                                            <div class="pass1"><label><?php _e('Amount Paid', 'evrplus_language'); ?></label></div>
                                            <div class="pass2"> <input type="text" name="mc_gross" size="25" value="<?php echo $mc_gross; ?>"></div>
                                        </li>

                                        <li>
                                            <div class="pass1"><label><?php _e('Payment Type', 'evrplus_language'); ?></label></div>
                                            <div class="pass2">
                                                <select name="payment_type">
                                                    <?php if ($payment_type == "full") { ?><option value="full"><?php _e('Full Payment', 'evrplus_language'); ?></option><?php
                                                    }
                                                    if ($payment_type == "partial") {
                                                        ?><option value="partial"><?php _e('Partial Payment', 'evrplus_language'); ?></option><?php
                                                    }
                                                    if ($payment_type == "deposit") {
                                                        ?><option value="deposit"><?php _e('Deposit', 'evrplus_language'); ?></option><?php
                                                        }
                                                        if ($payment_type == "donation") {
                                                            ?><option value="donation"><?php _e('Donation', 'evrplus_language'); ?></option><?php
                                                        }
                                                        if ($payment_type == "modify") {
                                                            ?><option value="modify"><?php _e('Modification', 'evrplus_language'); ?></option><?php
                                                        }
                                                        if ($payment_type == "cancel") {
                                                            ?><option value="cancel"><?php _e('Cancelation', 'evrplus_language'); ?></option><?php
                                                        }
                                                        if ($payment_type == "refund") {
                                                            ?><option value="refund"><?php _e('Refund', 'evrplus_language'); ?></option><?php }
                                                        ?>
                                                    <option value="full"><?php _e('Full Payment', 'evrplus_language'); ?></option>
                                                    <option value="partial"><?php _e('Partial Payment', 'evrplus_language'); ?></option>
                                                    <option value="deposit"><?php _e('Deposit', 'evrplus_language'); ?></option>
                                                    <option value="donation"><?php _e('Donation', 'evrplus_language'); ?></option>
                                                    <option value="modify"><?php _e('Modification', 'evrplus_language'); ?></option>
                                                    <option value="cancel"><?php _e('Cancelation', 'evrplus_language'); ?></option>
                                                    <option value="refund"><?php _e('Refund', 'evrplus_language'); ?></option>  
                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="pass1"><label><?php _e('Payment Method', 'evrplus_language'); ?></label>: </div>
                                            <div class="pass2">
                                                <select name="txn_type">
                                                    <?php if ($txn_type == "online") { ?> <option value="online"><?php _e('Online/Credit Card', 'evrplus_language'); ?></option><?php
                                                    }
                                                    if ($txn_type == "check") {
                                                        ?> <option value="check"><?php _e('Check', 'evrplus_language'); ?></option><?php
                                                    }
                                                    if ($txn_type == "cash") {
                                                        ?> <option value="cash"><?php _e('Cash', 'evrplus_language'); ?></option><?php
                                                    }
                                                    if ($txn_type == "credit") {
                                                        ?> <option value="credit"><?php _e('Event Credit', 'evrplus_language'); ?></option><?php }
                                                    ?>
                                                    <option value="online"><?php _e('Online/Credit Card', 'evrplus_language'); ?></option>
                                                    <option value="check"><?php _e('Check', 'evrplus_language'); ?></option>
                                                    <option value="cash"><?php _e('Cash', 'evrplus_language'); ?></option>
                                                    <option value="credit"><?php _e('Event Credit', 'evrplus_language'); ?></option>
                                                </select> 
                                            </div>
                                        </li>
                                        <li><div class="pass1"><label><?php _e('Transaction ID', 'evrplus_language'); ?></label></div>
                                            <div class="pass2"><input type="text" name="txn_id" size="45" value="<?php echo $txn_id; ?>"> </div>
                                        </li>


                                        <hr />
                                        <br />
                                        <li>
                                            <div class="pass1">
                                                <label><?php _e('Do you want to send a revised payment received notice to the payer?', 'evrplus_language'); ?></label>
                                            </div>
                                            <div class="pass2">
                                                <INPUT TYPE='radio' NAME='send_payment_rec'  VALUE='Y' id='trt1'><label for="trt1"><?php _e('Yes', 'evrplus_language'); ?></label>
                                                <INPUT TYPE='radio' id="trt2" NAME='send_payment_rec' VALUE='N' CHECKED><label for="trt2"><?php _e('No', 'evrplus_language'); ?></label>
                                            </div>
                                        </li>

                                        <hr />

                                        <?php
                                        echo "<input type='hidden' name='attendee_id' value='" . $attendee_id . "'>";
                                        echo "<input type='hidden' name='payment_id' value='" . $payment_id . "'>";
                                        echo "<input type='hidden' name='first_name' value='" . $fname . "'>";
                                        echo "<input type='hidden' name='last_name' value='" . $lname . "'>";
                                        echo "<input type='hidden' name='payer_email' value='" . $email . "'>";
                                        echo "<input type='hidden' name='address_name' value='" . $fname . " " . $lname . "'>";
                                        echo "<input type='hidden' name='address_street' value='" . $address . "'>";
                                        echo "<input type='hidden' name='address_city' value='" . $city . "'>";
                                        echo "<input type='hidden' name='address_state' value='" . $state . "'>";
                                        echo "<input type='hidden' name='address_zip' value='" . $zip . "'>";
                                        echo "<input type='hidden' name='address_country' value='" . $state . "'>";
                                        echo "<input type='hidden' name='address_status' value='VALID'>";
                                        echo "<input type='hidden' name='item_name' value='Event Payment: " . $event_name . " (" . $event_id . ")'>";
                                        echo "<input type='hidden' name='item_number' value='" . $event_id . "'>";
                                        echo "<input type='hidden' name='quantity' value='1'>";
                                        echo "<input type='hidden' name='attendee_pay' value='paynow'>";
                                        echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
                                        echo "<input type='hidden' name='action' value='update_payment'>";
                                        ?>
                                </ul>
                                <?php 

                                if(EventPlus_Models_Payments::isValidMethod($txn_type) == false): ?>
                                    <hr/><p class="att" id="uyt"><input class="satt" type="submit" name="Submit" value="<?php _e('UPDATE PAYMENT', 'evrplus_language'); ?>"></p>
                                <?php endif; ?>
                                </form>

                                </p>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>jQuery(function () {
        jQuery(document).tooltip({position: {my: 'left center', at: 'right+10 center', using: function (position, feedback) {
                    jQuery(this).css(position);
                    jQuery("<div>").addClass("arrow").addClass(feedback.vertical).addClass(feedback.horizontal).appendTo(this);
                }}});
    });</script>
