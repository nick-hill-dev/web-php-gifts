<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Find Friend - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}
    
    <div class="container">
        <p><a href="{$baseUrl}/myLists">&laquo; Home</a></p>
        
        <h2>Find Friend</h2>

        <div>
            <form method="post">
                <label for="friendName">Friend Username, First Name or Last Name</label>
                <input type="text" placeholder="Enter Name" name="friendName" required="required" />
                <button>Search</button>
            </form>
        </div>
        
        <form method="post">
            
        </form>
    
        <div class="bottomContainer">
            <a href="{$baseUrl}/myLists">Cancel</a>
        </div>
    </div>
    
</body>
</html>