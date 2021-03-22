<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Register - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}

    <form method="post">

        <div class="container">
    
            <h2>Register Gifts Account</h2>
       
            <label for="userName">Username</label>
            <input type="text" placeholder="Enter Username" name="userName" required="required" />
            
            <label for="firstName">First Name</label>
            <input type="text" placeholder="Enter First Name" name="firstName" required="required" />
            
            <label for="lastName">Last Name</label>
            <input type="text" placeholder="Enter Last Name" name="lastName" required="required" />

            <label for="password">Password</label>
            <input type="password" placeholder="Enter Password" name="password" required="required" />
            
            <label for="emailAddress">Email Address</label>
            <input type="text" placeholder="Enter Email Address" name="emailAddress" required="required" />
        
            <button type="submit">Create Account</button>
        </div>
    
    </form>
    
    <div class="bottomContainer">
        <span><a href="{$baseUrl}/login">Cancel</a></span>
    </div>
    
</body>
</html>