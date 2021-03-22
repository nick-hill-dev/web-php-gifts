<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('giftID', 'listID'));

$database = new Database($config);
mustBeOwnerOfList($database, $_SESSION['userID'], $_GET['listID']);

$database->deleteGift(array('giftID' => $_GET['giftID']));
header('Location: '.$config['baseUrl'].'/lists/'.$_GET['listID']);

?>