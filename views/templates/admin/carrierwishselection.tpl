<p id="demo">{$urls.js_url}</p>

{if $options}
    <h2> 
        <span class="color: red">*</span>{l s='Choose Perfect Gift delivery' mod='wishdeliveryselection'} 
    </h2>
    {if isset($options.registered_email) && $options.registered_email == 1}
        <label name="registered_email">
            <input type="radio" id="registered_email" name="wish_form" checked> {l s='Send Perfect Gift on my email: ' mod='wishdeliveryselection'}
            {$customer.email}
        </label>
        <div id="registered_email_form" hidden>
            {l s='Wishes: ' mod='wishdeliveryselection'}
            <textarea cols="10" rows="1" maxlength="400" placeholder="We wish you a merry christmas"></textarea>
        </div>
        <br>
    {/if}
    {if isset($options.other_email) && $options.other_email == 1}
        <label name="other_email">
            <input type="radio" id="other_email" name="wish_form"> {l s='Send Perfect Gift on other email' mod='wishdeliveryselection'}
        </label>
        <br>
    {/if}

    {if isset($options.sms) && $options.sms == 1}
        <label name="sms">
            <input type="radio" id="sms" name="wish_form"> {l s='Send SMS' mod='wishdeliveryselection'}
        </label>
    {/if}
    <br>
    <br>
{/if}