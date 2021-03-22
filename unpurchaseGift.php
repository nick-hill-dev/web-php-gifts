<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('giftID'));

$database = new Database($config);

$gift = $database->getGift(array('giftID' => $_GET['giftID']));
$list = $database->getList(array('listID' => $gift['list_id']));
mustBeFriendOf($database, $list['account_id']);
mustHaveAccessToList($database, $list['id']);

$database->markAsUnpurchased(array('giftID' => $_GET['giftID'], 'userID' => $_SESSION['userID']));

header('Location: '.$config['baseUrl'].'/lists/'.$list['id'].'/gifts/'.$_GET['giftID']);

?>