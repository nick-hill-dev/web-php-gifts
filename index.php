<?

require_once('core.php');

mustBeLoggedIn();

header('Location: '.$config['baseUrl'].'/myLists');

?>