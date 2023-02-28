{if $options}
    <h2> 
        {l s='Choose possible product options' mod='wishdeliveryselection'} 
    </h2>
    {if isset($options.registered_email) && $options.registered_email == 1}
        <label name="registered_email">
            <input type="checkbox" name="registered_email" value="true"> {l s='Registered email' mod='wishdeliveryselection'}
        </label>
        <br>
    {/if}
    {if isset($options.other_email) && $options.other_email == 1}
        <label name="other_email">
            <input type="checkbox" name="other_email" value="true"> {l s='Other email' mod='wishdeliveryselection'}
        </label>
        <br>
    {/if}

    {if isset($options.sms) && $options.sms == 1}
        <label name="sms">
            <input type="checkbox" name="sms" value="true"> {l s='SMS' mod='wishdeliveryselection'}
        </label>
    {/if}
{/if}