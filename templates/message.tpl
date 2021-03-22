<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>{$title} - GiftMouse</title>
</head>
<body>
    {include file='c-top.tpl'}
    
    <div class="container">
        <p><a href="{$baseUrl}/myLists">&laquo; Home</a></p>
        
        <h2>{$title}</h2>

        <p class="{$type}">{$message}</p>
       
    </div>
    
</body>
</html>