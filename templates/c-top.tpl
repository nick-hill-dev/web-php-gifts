<div class="mainLogo">
    <a href="{$baseUrl}"><img src="{$baseUrl}/images/mainLogo.png" /></a>
    {if $user.user_name|default:'' != ''}
        <p class="topRight">
            {include file='c-accountName.tpl' userName=$user.user_name}<br />
            &nbsp;<a href="{$baseUrl}/logout">Log out</a>
        </p>
    {/if}
</div>