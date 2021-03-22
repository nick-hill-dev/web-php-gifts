<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('giftID', 'listID'));

$database = new Database($config);
mustBeOwnerOfList($database, $_SESSION['userID'], $_POST['listID']);

$database->copyGift(array('giftID' => $_GET['giftID'], 'listID' => $_POST['listID']));
header('Location: '.$config['baseUrl'].'/lists/'.$_POST['listID']);

?>