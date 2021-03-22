{assign var=id value=100000|mt_rand:900000}
<form id="form{$id}" method="post" action="{$action}" style="display: none;">
    <script>
        function confirm{$id}() {
            if (confirm('{$message|default:'Are you sure?'}')) {
                $id('form{$id}').submit();
            }
        }
    </script>
</form>
<button type="button" class="{$buttonClass|default:'redButton'}" onclick="confirm{$id}(); return false;">{$label}</button>