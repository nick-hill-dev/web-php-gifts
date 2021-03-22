<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Login - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}

    <form method="post">

        <div class="container">
           
            <h2>Login to Gifts</h2>
    
            <div class="loginImageContainer">
                <img src="images/defaultAvatar.png" />
            </div>
            
            {if $errorMessage|default:'' != ''}<p class="error">{$errorMessage}</p>{/if}
        
            <label for="userName">Username</label>
            <input type="text" placeholder="Enter Username" name="userName" value="{$smarty.post.userName|default:''}" required="required" />

            <label for="password">Password</label>
            <input type="password" placeholder="Enter Password" name="password" required="required" />
        
            <button type="submit">Login</button>
        </div>

        <div class="bottomContainer">
            <span><a href="{$baseUrl}/forgotPassword">Forgot password?</a></span>
        </div>
    
    </form>
    
    <div class="container">
        <button onclick="window.location = 'register';">Create Account</button>
    </div>
    
</body>
</html>