<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('listID', 'giftID', 'linkID'));

$database = new Database($config);
mustBeOwnerOfList($database, $_SESSION['userID'], $_GET['listID']);

$database->deleteGiftLink(array('linkID' => $_GET['linkID']));
header('Location: '.$config['baseUrl'].'/lists/'.$_GET['listID'].'/gifts/'.$_GET['giftID']);

?>