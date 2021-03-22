<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Forgot Password - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}

    <form method="post">

        <div class="container">
    
            <h2>Forgot Password</h2>
       
            <label for="userName">Username</label>
            <input type="text" placeholder="Enter Username" name="userName" required="required" />
            
            <label for="emailAddress">Email Address</label>
            <input type="text" placeholder="Enter Email Address" name="emailAddress" required="required" />
            
            <button type="submit">Reset Password</button>
        </div>
    
        <div class="bottomContainer">
            <span><a href="{$baseUrl}/login">Cancel</a></span>
        </div>
        
    </form>
    
</body>
</html>