<?

require_once('core.php');

unset($_SESSION['userName']);
unset($_SESSION['userID']);

header('Location: '.$config['baseUrl'].'/login');

?>