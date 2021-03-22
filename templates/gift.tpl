<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>{$gift.title} - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}

    <div class="container">
        <p><a href="{$baseUrl}/lists/{$list.id}">&laquo; {$list.name}</a></p>
        
        <h1>{$gift.title}</h1>
        
        <p>
            {foreach from=$config.searchBrands item=searchBrand}
                <span class="minorButton"><a href="{$searchBrand.urlFormat|replace:'$1':$searchString}" target="_new">🔍 {$searchBrand.label}</a></span>&nbsp;
            {/foreach}
        </p>
        {if $owner.id != $user.id}
        
            <p>Gift requested by {include file='c-accountName.tpl' userName=$owner.user_name}</p>
        
            {foreach from=$gift.purchases item=purchase}
                <p>Purchased by {include file='c-accountName.tpl' userName=$purchase.user_name}</p>
            {/foreach}
            
            {if !$purchasedByMe}
                <p class="info"><img src="{$baseUrl}/images/infoIcon.png" style="height: 30px; vertical-align: middle;"/>&nbsp; If you mark this gift as purchased, then everyone else will be able to see that it has been purchased. However, {$owner.first_name} will not see any change to the listing.</p>
            {/if}
            
        {/if}
 
        {if $user.id != $list.account_id}
            {if $purchasedByMe}
                <div class="info">
                    <img src="{$baseUrl}/images/infoIcon.png" style="height: 30px; vertical-align: middle;"/>&nbsp; You have previously said that you purchased this item.
                    {include file='c-postWithConfirm.tpl' label='Undo' buttonClass='redButton' action={$baseUrl|cat:'/lists/'|cat:$gift.list_id|cat:'/gifts/'|cat:$gift.id|cat:'/unpurchased'}}
                </div>
            {else}
                {include file='c-postWithConfirm.tpl' label='Mark as Purchased' buttonClass='greenButtonFullSize' action={$baseUrl|cat:'/lists/'|cat:$gift.list_id|cat:'/gifts/'|cat:$gift.id|cat:'/purchased'}}
            {/if}
        {/if}
        
        <h2>Notes</h2>
        {if $gift.notes == ''}
            <p id="existingNotes" class="null">No notes given.</p>
        {else}
            <p id="existingNotes">{$gift.notes|nl2br}</p>
        {/if}
        {if $owner.id == $user.id}
            <script>
                function editDescription() {
                    $id('existingNotes').style.display = 'none';
                    $id('editDescriptionButton').style.display = 'none';
                    $id('changeDescriptionForm').style.display = 'block';
                }
            </script>
            
            <p id="editDescriptionButton" class="button"><a href="javascript:editDescription();">Edit Description</a></p>
            <form id="changeDescriptionForm" class="editRegion" method="post" action="{$baseUrl}/lists/{$list.id}/gifts/{$gift.id}/edit" style="display: none;">
                <input type="text" placeholder="Enter Title" name="newTitle" required="required" value="{$gift.title}" />
                <textarea name="newNotes">{$gift.notes}</textarea>
                <button>Save Changes</button>
            </form>
            
            <script>
                function copy() {
                    $id('copyButton').style.display = 'none';
                    $id('copyForm').style.display = 'block';
                }
            </script>
            
            <p id="copyButton" class="button"><a href="javascript:copy();">Copy To Another List</a></p>
            <form id="copyForm" class="editRegion" method="post" action="{$baseUrl}/lists/{$list.id}/gifts/{$gift.id}/copy" style="display: none;">
                <p>Copy to:</p>
                <select name="listID" onchange="javascript:$id('copyForm').submit();">
                    <option>Select List</option>
                    {foreach from=$lists item=otherList}
                        {if $otherList.id != $list.id}
                            <option value="{$otherList.id}">{$otherList.name}</option>
                        {/if}
                    {/foreach}
                </select>
            </form>
        {/if}
        
        <h2>Website Links</h2>
        {if $gift.links|@count == 0}
            <p class="null">No links given.</p>
        {else}
            {foreach from=$gift.links item=link}
            <div class="friendBalloon">
                <div>
                    <a href="{$link.page_url}"><img src="{$link.image_url}" style="max-width: 400px;" /></a>
                </div>
                <p><a href="{$link.page_url}">{$link.page_title|default:$link.page_url}</a></p>
                {if $user.id == $list.account_id}
                    {include file='c-postWithConfirm.tpl' label='Delete Website Link' buttonClass='redButton' action={$baseUrl|cat:'/lists/'|cat:$list.id|cat:'/gifts/'|cat:$gift.id|cat:'/links/'|cat:$link.id|cat:'/delete'}}
                {/if}
            </div>
            {/foreach}
        {/if}
        
        {if $owner.id == $user.id}
            <script>
                function startAddingNewLink() {
                    $id('addLinkButton').style.display = 'none';
                    $id('addLinkForm').style.display = 'inline';
                }
            </script>
            <p id="addLinkButton" class="button"><a href="javascript:startAddingNewLink();">Add Link</a></p>
            <form id="addLinkForm" method="post" action="{$baseUrl}/lists/{$list.id}/gifts/{$gift.id}/edit" style="display: none;">
                <div class="friendBalloon">
                    <input type="text" placeholder="Enter Website Address (URL)" name="url" onchange="handleUrlChanged();" />
                    {include file='c-linkScraper.tpl'}
                    <button>Save New Link</button>
                </div>
            </form>
        {/if}
        
        {if $user.id == $list.account_id}
            {include file='c-postWithConfirm.tpl' label='Delete Gift Request' buttonClass='redButtonFullSize' action={$baseUrl|cat:'/lists/'|cat:$list.id|cat:'/gifts/'|cat:$gift.id|cat:'/delete'}}
        {/if}
 
    </div>
    
</body>
</html>