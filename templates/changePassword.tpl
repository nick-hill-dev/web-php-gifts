<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Change Password - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}

    <form method="post">

        <div class="container">
    
            <h2>Change Password</h2>
       
            <label for="username">Username</label>
            <input type="text" placeholder="Enter Username" name="userName" required="required" />
            
            <label for="password">New Password</label>
            <input type="password" placeholder="Enter Password" name="password" required="required" />
        
            <label for="changeCode">Change Code</label>
            <input type="text" placeholder="Enter Change Code" name="changeCode" required="required" />
            
            <button type="submit">Change Password</button>
        </div>
    
    </form>
    
</body>
</html>