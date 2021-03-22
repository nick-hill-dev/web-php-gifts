<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>{$list.name} - GiftMouse</title>
</head>
<body>
    
    {include file='c-top.tpl'}

    <div class="container">
        <p><a href="{$baseUrl}/myLists">&laquo; Home</a></p>
    
        <h1>{$list.name}</h1>
        <p>{include file='c-visibility.tpl' visibility=$list.visibility color='black'}</p>

        {if $owner.id != $user.id}
            <p>List owned by {include file='c-accountName.tpl' userName=$owner.user_name}</p>
        {/if}
        
        {if $owner.id == $user.id}
            <script>
                function editDetails() {
                    $id('editDetailsButton').style.display = 'none';
                    $id('changeDetailsForm').style.display = 'inline';
                }
            </script>
            <p id="editDetailsButton" class="button"><a href="javascript:editDetails();">Edit Details</a></p>
            <form id="changeDetailsForm" method="post" action="{$baseUrl}/lists/{$list.id}/edit" style="display: none;">
                <label for="newName">List Name</label>
                <input type="text" placeholder="Enter List Name" name="newName" required="required" value="{$list.name}" />
                
                <label for="newVisibility">Visibility</label>
                <select name="newVisibility">
                    <option value="friends"{if $list.visibility == 'friends'} selected="selected"{/if}>Friends</option>
                    <option value="private"{if $list.visibility == 'private'} selected="selected"{/if}>Private</option>
                </select>
                
                <button>Save Changes</button>
            </form>
        {/if}
        
        {if $list.items|@count gt 0}
            {foreach from=$list.items item=item}
                <div class="gift">
                    <h3>
                        <a href="{$baseUrl}/lists/{$list.id}/gifts/{$item.id}">{$item.title}</a>
                    </h3>
                    {if $item.notes|default:'' != ''}<p>{$item.notes|nl2br}</p>{/if}
                    {if $owner.id != $user.id}
                        {foreach from=$item.purchases item=purchase}
                            <p class="info"><img src="{$baseUrl}/images/infoIcon.png" style="height: 30px; vertical-align: middle;"/>&nbsp; Purchased by {include file='c-accountName.tpl' userName=$purchase.user_name}.</p>
                        {/foreach}
                    {/if}
                    {if $item.links|@count gt 0}
                        <table class="giftLinksTable">
                            {foreach from=$item.links item=link}
                            <tr>
                                <td style="text-align: center;">
                                    <a href="{$link.page_url}" target="_new">
                                        <img class="thumbnail" src="{if $link.image_url|default:'' != ''}{$link.image_url}{else}{$baseUrl}/images/redGift.png{/if}" />
                                    </a>
                                </td>
                                <td>
                                    <span><a href="{$link.page_url}" target="_new">{$link.page_title|default:$link.page_url}</a></span>
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                    {/if}
                </div>
            {/foreach}
        {else}
            <p>There are no gifts in this list.</p>
        {/if}
        
        {if $user.id == $list.account_id}
            <p class="button"><a href="{$baseUrl}/lists/{$list.id}/gifts/new">Add Gift</a></p>
            {include file='c-postWithConfirm.tpl' label='Delete Gift List' buttonClass='redButtonFullSize' action={$baseUrl|cat:'/lists/'|cat:$list.id|cat:'/delete'}}
        {/if}
    </div>
    
</body>
</html>