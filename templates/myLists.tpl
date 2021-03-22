<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>My Lists - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}

    <div class="container">
    
        <p>Logged in as {$user.user_name} ({$user.first_name} {$user.last_name})</p>
        
        <h1>My Gift Lists</h1>

        {if $myLists|@count gt 0}
            {foreach from=$myLists item=list}
                <div class="list">
                
                    <div>
                        <p style="float: left;">
                            <b><a href="{$baseUrl}/lists/{$list.id}">{$list.name}</a></b>
                            &nbsp;({if $list.gift_count == 0}No gifts{elseif $list.gift_count == 1}1 gift{else}{$list.gift_count} gifts{/if})
                        </p>
                        <p style="float: right;">
                            {include file='c-visibility.tpl' visibility=$list.visibility color='white'}
                        </p>
                    </div>
                    <div style="clear: both;">
                        <p>
                            <span class="minorButton white"><a href="{$baseUrl}/lists/{$list.id}/gifts/new">Add a Gift</a></span>
                        </p>
                    </div>

                </div>
            {/foreach}
        {else}
            <p>You do not have any lists.</p>
        {/if}
            
        <p class="button"><a href="{$baseUrl}/lists/new">Create Gift List</a></p>
            
        {if ($friendRequests.forMe|@count gt 0) || ($friendRequests.forOthers|@count gt 0)}
            <h1>Friend Requests</h1>
            
            {foreach from=$friendRequests.forOthers item=$friendRequest}
                <form id="cancelFriendRequestForm" method="post" action="{$baseUrl}/friends/cancel/{$friendRequest.id}">
                    <p>Awaiting friend request response from: <b>{$friendRequest.first_name} {$friendRequest.last_name}</b>
                        <button class="redButton">Cancel</button>
                    </p>
                </form>
            {/foreach}
            
            {foreach from=$friendRequests.forMe item=$friendRequest}
            <div class="friendBalloon">
                <div class="friendBalloonHeader">
                    {include file='c-fullAccountName.tpl' account=$friendRequest}
                </div>
                
                <form method="post" action="{$baseUrl}/friends/confirm/{$friendRequest.id}">
                    <button>Accept</button>
                </form>
                
                {include file='c-postWithConfirm.tpl' label='Delete Request' buttonClass='redButtonFullSize' action={$baseUrl|cat:'/friends/deny/'|cat:$friendRequest.id}}

            </div>
            {/foreach}
        {/if}
        
        <h1>My Friends</h1>
        
        {if $friends|@count gt 0}
            {foreach from=$friends item=friend}
            <div class="friendBalloon">
                <div class="friendBalloonHeader">
                    <div style="float: left;">
                        {include file='c-fullAccountName.tpl' account=$friend}
                    </div>
                    <div style="float: right;">
                        {include file='c-postWithConfirm.tpl' label='Unfriend' action={$baseUrl|cat:'/friends/'|cat:$friend.id|cat:'/unfriend'}}
                    </div>
                    <div style="clear: both;">
                    </div>
                </div>
                {if $friend.lists|@count == 0}
                    <p>{$friend.first_name} hasn't shared any lists.</p>
                {else}
                    <div class="list">
                    {foreach from=$friend.lists item=list}
                        <p>
                            <b><a href="{$baseUrl}/lists/{$list.id}">{$list.name}</a></b>
                            &nbsp;({if $list.gift_count == 0}No gifts{elseif $list.gift_count == 1}1 gift{else}{$list.gift_count} gifts{/if})
                        </p>
                    {/foreach}
                    </div>
                {/if}
            </div>
            {/foreach}
        {else}
            <p>You do not have any friends.</p>
        {/if}
            
        <p class="button"><a href="{$baseUrl}/friends/add">Add Friend</a></p>
    
    </div>
    
</body>
</html>