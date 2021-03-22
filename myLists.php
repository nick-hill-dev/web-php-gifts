<?

require_once('core.php');

mustBeLoggedIn();

$database = new Database($config);

$page = createPage($database);
$page->assign('myLists', $database->getLists(array('accountID' => $_SESSION['userID'])));
$page->assign('friendRequests', $database->getFriendRequests(array('userID' => $_SESSION['userID'])));
$page->assign('friends', $database->getFriends(array('userID' => $_SESSION['userID'])));
$page->display('myLists.tpl');

?>