<script>
function handleUrlChanged() {
    $id('imageWarning').style.display = 'none';
    $id('imageLoading').style.display = 'inline';
    $id('selectImagePrompt').style.display = 'none';
    $id('imagesPanel').style.display = 'none';
    $id('urlPageTitle').style.display = 'none';
    $name('pageTitle').value = '';
    $name('imageUrl').value = '';
    var requestUrl = '{$baseUrl}/api/scrape.php?url=' + encodeURI($name('url').value);
    
    $httpGetJson(requestUrl, function(data) {
    
        {if $callback|default:'' != ''}{$callback}(data);{/if}
        
        $id('imageLoading').style.display = 'none';
        $id('selectImagePrompt').style.display = 'block';
        $id('urlPageTitle').style.display = 'inline';
        $id('urlPageTitle').innerHTML = data.title;
        $name('pageTitle').value = (data.type == 'webPage' ? data.title : 'Image');
        thumbnails = data;
        
        var div = $id('imagesPanel');
        div.style.display = 'block';
        $asDiv('imagesPanel').clear();
        for (var i = 0; i < data.images.length; i++) {
            var image = document.createElement('img');
            image.src = data.images[i];
            image.className = 'selectableThumbnail';
            div.appendChild(image);
            
            image.addEventListener('click', function (ev) {
                var element = event.target;
                $asDiv('imagesPanel').clear();
                div.appendChild(element);
                $name('imageUrl').value = element.src;
                $id('selectImagePrompt').style.display = 'none';
            }, false);
        }
        
    }, function() {
    
        $id('imageLoading').style.display = 'none';
        $id('imageWarning').style.display = 'inline';
        
    });
}
</script>

<p id="imageWarning" class="warning" style="display: none;">Could not load images from the specified address. No image will be used.</p>
<img id="imageLoading" src="{$baseUrl}/images/loading.gif" style="display: none;" />
<p id="selectImagePrompt" class="info" style="display: none;"><img src="{$baseUrl}/images/infoIcon.png" style="height: 30px; vertical-align: middle;"/>&nbsp; Select an image to use as the thumbnail for this gift.</p>

<p id="urlPageTitle" style="display: none;"></p>
<div id="imagesPanel" style="display: none;">
</div>

<input type="hidden" name="pageTitle" value="" />
<input type="hidden" name="imageUrl" value="" />