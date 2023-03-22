<div class="panel col-lg-12">
    <div class="panel-heading"> 
        {l s='Choose possible product options' mod='wishdeliveryselection'} 
    </div>
    <label name="registered_email">
        <input type="checkbox" name="registered_email" value="true" form="form-wishdeliveryselection_products"
            {if !isset($registered_email) || $registered_email == true } 
                checked
            {/if}>
        {l s='Registered email' mod='wishdeliveryselection'}
    </label>
    <br>
    <label name="other_email">
        <input type="checkbox" name="other_email" value="true" form="form-wishdeliveryselection_products" 
            {if !isset($other_email) || $other_email == true } 
                checked
            {/if}>
        {l s='Other email' mod='wishdeliveryselection'}
    </label>
    <br>
    <label name="sms">
        <input type="checkbox" class="md-checkbox" name="sms" value="true" form="form-wishdeliveryselection_products"
            {if !isset($sms) || $sms == true } 
                checked
            {/if}>
        {l s='SMS' mod='wishdeliveryselection'}
    </label>
    <div class="panel-footer">
        <input type="submit" class="btn btn-default pull-right" name="submitWishdeliveryselectionModule" value="Submit" form="form-wishdeliveryselection_products">
    </div>
</div>
{* <br>
<br>
<h5> {l s='To apply those options you must click "Save" button and refresh the page' mod='wishdeliveryselection'} *}
