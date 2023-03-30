<div class="panel col-lg-12">
    <div class="panel-heading"> 
        {l s='Choose possible product options' mod='wishdeliveryselection'} 
    </div>
    <label name="registered_email">
        <input type="checkbox" name="registered_email" value="true" form="form-wishformlist"
            {if !isset($registered_email) || $registered_email == true } 
                checked
            {/if}>
        {l s='Registered email' mod='wishdeliveryselection'}
    </label>
    <br>
    <label name="other_email">
        <input type="checkbox" name="other_email" value="true" form="form-wishformlist" 
            {if !isset($other_email) || $other_email == true } 
                checked
            {/if}>
        {l s='Other email' mod='wishdeliveryselection'}
    </label>
    <br>
    <label name="sms">
        <input type="checkbox" class="md-checkbox" name="sms" value="true" form="form-wishformlist"
            {if !isset($sms) || $sms == true } 
                checked
            {/if}>
        {l s='SMS' mod='wishdeliveryselection'}
    </label>
    <div class="panel-footer">
        <input type="submit" class="btn btn-default pull-right" name="submitWishdeliveryselectionModule" value="{l s='Save' mod='wishdeliveryselection'}" form="form-wishformlist">
    </div>
</div>
