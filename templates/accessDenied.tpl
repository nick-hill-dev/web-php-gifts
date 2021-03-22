<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Access Denied - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}
    
    <div class="container">
        <p><a href="{$baseUrl}/myLists">&laquo; Home</a></p>
        
        <h2>Access Denied</h2>

        <p class="error">You do not have access to this gift list.</p>
        
        {if isset($owner)}
        <p>You need to add {$owner.first_name} {$owner.last_name} (<b>{$owner.user_name}</b>) as a friend first.</p>
        
        <div class="friendBalloon">
            <div class="friendBalloonHeader">
                {include file='c-fullAccountName.tpl' account=$owner}
            </div>
            <form method="post" action="{$baseUrl}/friends/add/{$owner.id}">
                <button>Send Friend Request</button>
            </form>
        </div>
        {/if}
        
    </div>
    
</body>
</html>