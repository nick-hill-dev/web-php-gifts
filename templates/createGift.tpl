<!DOCTYPE html>

<html lang="en">
<head>
    {include file='c-head.tpl'}
    <title>Create Gift - GiftMouse</title>
</head>
<body>
    <script>
    window.onload = function() {
        $name('title').focus();
        $name('title').select();
    };
    </script>
    
    {include file='c-top.tpl'}

    <div class="container">
        <p><a href="{$baseUrl}/lists/{$list.id}">&laquo; {$list.name}</a></p>
    
        <h2>Create Gift</h2>

        <form method="post">
            
            <label>List</label>
            <p>{$list.name}</p>

            <label for="title">Title</label>
            <input type="text" placeholder="Enter Title" name="title" required="required" />
            <p>
                <span id="copyToTitleButton" class="minorButton" style="display: none;">
                    <a href="javascript: copyToTitle();">Copy Title from Link</a>
                </span>
            </p>

            <label for="notes">Notes</label>
            <textarea name="notes"></textarea>
            
            <label for="url">Link</label>
            <input type="text" placeholder="Enter Website Address (URL)" name="url" onchange="handleUrlChanged();" />
            
            <script>
            var title = '';
            
            function handleUrlScraped(data) {
                $id('copyToTitleButton').style.display = 'inline';
                title = data.title;
            }
            
            function copyToTitle() {
                $name('title').value = title;
            }
            </script>
            
            {include file='c-linkScraper.tpl' callback='handleUrlScraped'}
            
            <button type="submit">Create</button>
        </form>
    
        <div class="bottomContainer">
            <span><a href="{$baseUrl}/lists/{$list.id}">Cancel</a></span>
        </div>
    </div>
    
</body>
</html>