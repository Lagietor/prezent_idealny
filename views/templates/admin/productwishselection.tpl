<h2> 
    {l s='Choose possible product options' mod='wishdeliveryselection'} 
</h2>
<br>
{* <form method="POST"> *}
<label name="registered_email">
    <input type="checkbox" name="registered_email"> {l s='Registered email' mod='wishdeliveryselection'}
</label>
<br>
<label name="other_email">
    <input type="checkbox" name="other_email"> {l s='Other email' mod='wishdeliveryselection'}
</label>
<br>
<label name="sms">
    <input type="checkbox" name="sms"> {l s='SMS' mod='wishdeliveryselection'}
</label>
    {* <br>
    <br>
    <input type="submit" name="wish_options_submit" value={l s='Save' mod='wishdeliveryselection'}> *}
{* </form> *}
{assign var='foo' value='Smarty'}