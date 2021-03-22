<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Find Friend - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}
    
    <div class="container">
        <p><a href="{$baseUrl}/friends/add">&laquo; Friend Search</a></p>
        
        <h2>Find Friend</h2>

        <p>Searched for: {$searchTerm}</p>
        
        {if $searchResults|@count == 0}
            <p>No search results.</p>
        {else}
            {foreach from=$searchResults item=$searchResult}
            <div class="friendBalloon">
                <div class="friendBalloonHeader">
                    {include file='c-fullAccountName.tpl' account=$searchResult}
                </div>
                <form method="post" action="{$baseUrl}/friends/add/{$searchResult.id}">
                    <button>Send Friend Request</button>
                </form>
            </div>
            {/foreach}
        {/if}
        
        <div class="bottomContainer">
            <a href="{$baseUrl}/friends/add">Search again</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{$baseUrl}/myLists">Cancel</a><br />
        </div>
    </div>
    
</body>
</html>