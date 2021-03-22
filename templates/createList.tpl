<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Create List - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}

    <div class="container">
        <p><a href="{$baseUrl}/myLists">&laquo; Home</a></p>
        
        <h2>Create Gift List</h2>

        <form method="post">
        
            <label for="name">List Name</label>
            <input type="text" placeholder="Enter List Name" name="name" required="required" />

            <label for="visibility">Visibility</label>
            <select name="visibility">
                <option value="friends">Friends</option>
                <option value="private">Private</option>
            </select>
                
            <button type="submit">Create</button>
        </form>
    
        <div class="bottomContainer">
            <span><a href="{$baseUrl}/myLists">Cancel</a></span>
        </div>
    </div>
    
</body>
</html>