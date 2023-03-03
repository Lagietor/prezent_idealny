{if $options}
    <h2> 
        {l s='Choose Perfect Gift delivery' mod='wishdeliveryselection'} 
    </h2>
    {* REGISTERED EMAIL *}
    {if isset($options.registered_email) && $options.registered_email == 1}
        <label name="registered_email">
            <input type="radio" id="registered_email" name="wish_form" checked> 
            {l s='Send Perfect Gift on my email: ' mod='wishdeliveryselection'}
            {$customer.email}
        </label>
        <div id="registered_email_form" style="display: none">
            <span style="color: red">*</span>{l s='Wishes: ' mod='wishdeliveryselection'}
            <br><br>
            <textarea class="serp-watched-description form-control" id="registered_email_wishes" name="registered_email_wishes"
            maxlength="400" placeholder="Happy Birthday!" required="required"></textarea>
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
        <label name="other_email">
            <input type="radio" id="other_email" name="wish_form" 
            {if !isset($options.registered_email) || $options.registered_email != 1}
                checked
            {/if}> 
            {l s='Send Perfect Gift on other email' mod='wishdeliveryselection'}
        </label>
        <div id="other_email_form" style="display: none">
            <span style="color: red">*</span>{l s="Other email: " mod="wishdeliveryselection"}
            <br><br>
            <input type="text" class="form-control" required="required">
            <br><br>

            {l s="Delivery date: " mod="wishdeliveryselection"}
            <br><br>
            <input type="date" name="other_email_datetime" class="input-group datepicker">
            <br><br>

            <span style="color: red">*</span>{l s='Wishes: ' mod='wishdeliveryselection'}
            <br><br>
            <textarea class="serp-watched-description form-control" id="other_email_wishes" name="registered_email_wishes"
            maxlength="400" placeholder="Happy Birthday!" required="required"></textarea>
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
        <label name="sms">
            <input type="radio" id="sms" name="wish_form"
            {if (!isset($options.registered_email) || $options.registered_email != 1) &&
                (!isset($options.other_email) || $options.other_email != 1)
            }
                checked
            {/if}>
            {l s='Send SMS' mod='wishdeliveryselection'}
        </label>
        <div id="sms_form" style="display: none">
            <span style="color: red">*</span> {l s='Phone number :' mod='wishdeliveryselection'}
            <br><br>
            <input type="text" class="form-control" name="sms_phone_number" required="required"
            <br>
        </div>
        <br>
    {/if}
    <br>
{/if}