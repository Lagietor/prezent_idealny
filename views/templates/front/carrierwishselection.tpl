{if $options}
    <div>
    <h2> 
        {l s='Choose wish delivery option' mod='wishdeliveryselection'} 
    </h2>
    <div class="form-check">
        {* REGISTERED EMAIL *}
        {if isset($options.registered_email) && $options.registered_email == 1}
            <label name="registered_email" class="form-check-label mb-1" style="text-align: left">
                <input type="radio" class="form-check-input" id="registered_email" name="wish_form" form="js-delivery" value="1"
                {if $wish_option == "1" || !$wish_option}
                    checked
                {/if}> 
                {l s='Send Perfect Gift on my email: ' mod='wishdeliveryselection'}
                {$customer.email}
            </label>
            <div id="registered_email_form" style="display: none">
                <span style="color: red">*</span>{l s='Wishes: ' mod='wishdeliveryselection'}
                <br><br>
                <textarea class="serp-watched-description form-control" id="registered_email_wishes" name="registered_email_wishes"
                maxlength="400" placeholder="{l s='Happy Birthday!' mod='wishdeliveryselection'}" form="js-delivery">{$wish_message}</textarea>
                <small class="form-text text-muted text-right maxLength ">
                    <em>
                        {l s='Used' mod='wishdeliveryselection'}
                        <span id="registered_email_currentLength">0</span>
                        {l s='From' mod='wishdeliveryselection'}
                        <span class="currentTotalMax">400</span>
                        {l s='signs' mod='wishdeliveryselection'}
                    </em>
                </small>
            </div>
            <br>
        {/if}
        {* OTHER EMAIL *}
        {if isset($options.other_email) && $options.other_email == 1}
            <label name="other_email" class="form-check-label mb-1">
                <input type="radio" class="form-check-input" id="other_email" name="wish_form" form="js-delivery" value="2"
                {if (!isset($options.registered_email) || $options.registered_email != 1) || $wish_option == "2"}
                    checked
                {/if}> 
                {l s='Send Perfect Gift on other email' mod='wishdeliveryselection'}
            </label>
            <div id="other_email_form" style="display: none">
                <span style="color: red">*</span>{l s='Other email: ' mod='wishdeliveryselection'}
                <br><br>
                <input type="text" value="{$email_address}" class="form-control" form="js-delivery" id="other_email_address" name="other_email_address">
                <span name="other_email_address_error_message" id="other_email_address_error_message" style="display: none">{l s='Incorrect email address' mod='wishdeliveryselection'}</span>
                <br><br>

                {l s='Delivery date: ' mod='wishdeliveryselection'}
                <br><br>
                <input type="date" name="other_email_datetime" value="{$delivery_date}" id="other_email_datetime" class="input-group datepicker" form="js-delivery">
                <span name="other_email_datetime_error_message" id="other_email_datetime_error_message" style="display: none">{l s='Delivery date must be set at least one day after today' mod='wishdeliveryselection'}</span>
                <br><br>

                <span style="color: red">*</span>{l s='Wishes: ' mod='wishdeliveryselection'}
                <br><br>
                <textarea class="serp-watched-description form-control" id="other_email_wishes" name="other_email_wishes"
                maxlength="400" placeholder="{l s='Happy Birthday!' mod='wishdeliveryselection'}" form="js-delivery">{$wish_message}</textarea>
                <small class="form-text text-muted text-right maxLength ">
                    <em>
                        {l s='Used' mod='wishdeliveryselection'}
                        <span id="other_email_currentLength">0</span>
                        {l s='From' mod='wishdeliveryselection'}
                        <span class="currentTotalMax">400</span>
                        {l s='signs' mod='wishdeliveryselection'}
                    </em>
                </small>
            </div>
            <br>
        {/if}
        {* SMS *}
        {if isset($options.sms) && $options.sms == 1}
            <label name="sms" class="form-check-label mb-1">
                <input type="radio" class="form-check-input" id="sms" name="wish_form" form="js-delivery" value="3"
                {if ((!isset($options.registered_email) || $options.registered_email != 1) &&
                    (!isset($options.other_email) || $options.other_email != 1)) ||
                    $wish_option == "3"
                }
                    checked
                {/if}>
                {l s='Send SMS' mod='wishdeliveryselection'}
            </label>
            <div id="sms_form" style="display: none">
                <span style="color: red">*</span> {l s='Phone number (+48)' mod='wishdeliveryselection'}
                <br><br>
                <input type="text" class="form-control" value="{$phone_number}" id="sms_phone_number" name="sms_phone_number" form="js-delivery"
                <br>
                <span name="sms_phone_number_error_message" id="sms_phone_number_error_message" style="display: none">{l s='Incorrect phone number' mod='wishdeliveryselection'}</span>
                <br>
            </div>
            <br>
        {/if}
    </div>
    <br>
{/if}