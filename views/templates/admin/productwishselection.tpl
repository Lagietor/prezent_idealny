<h2> 
    {l s='Choose possible product options' mod='wishdeliveryselection'} 
</h2>
<br>

<label name="registered_email">
    <input type="checkbox" name="registered_email" value="true" 
        {if !isset($productOptions.registered_email) || $productOptions.registered_email == "1" } 
            checked
        {/if}>
    {l s='Registered email' mod='wishdeliveryselection'}
</label>
<br>
<label name="other_email">
    <input type="checkbox" name="other_email" value="true" 
        {if !isset($productOptions.other_email) || $productOptions.other_email == "1" } 
            checked
        {/if}>
    {l s='Other email' mod='wishdeliveryselection'}
</label>
<br>
<label name="sms">
    <input type="checkbox" name="sms" value="true" 
        {if !isset($productOptions.sms) || $productOptions.sms == "1" } 
            checked
        {/if}>
    {l s='SMS' mod='wishdeliveryselection'}
</label>
<br>
<br>
<h5> {l s='To apply those options you must click "Save" button and refresh the page' mod='wishdeliveryselection'}
