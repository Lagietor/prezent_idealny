<div class="panel col-lg-12">
    <div class="panel-heading"> 
        {l s='See selected options' mod='wishdeliveryselection'} 
        <label name = "name">
            {$name}
        </label>
    </div>
    <label name="registered_email">
        <input type="checkbox" name="registered_email" value="true" disabled  form="form-wishformlist"
            {if isset($registered_email) && $registered_email == "1" } 
                checked
            {/if}>
        {l s='Registered email' mod='wishdeliveryselection'}
    </label>
    <br>
    <label name="other_email">
        <input type="checkbox" name="other_email" value="true" disabled  form="form-wishformlist" 
            {if isset($other_email) && $other_email == "1" } 
                checked
            {/if}>
        {l s='Other email' mod='wishdeliveryselection'}
    </label>
    <br>
    <label name="sms">
        <input type="checkbox" class="md-checkbox" name="sms" value="true" disabled  form="form-wishformlist"
            {if isset($sms) && $sms == "1" } 
                checked
            {/if}>
        {l s='SMS' mod='wishdeliveryselection'}
    </label>
</div>
