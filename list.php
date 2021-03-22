<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('id'));

$database = new Database($config);
$list = $database->getList(array('listID' => $_GET['id']));
mustNotBeNull($database, $list, 'List Deleted', 'The gift list no longer exists.');

mustBeFriendOf($database, $list['account_id']);
mustHaveAccessToList($database, $_GET['id']);

$page = createPage($database);
$page->assign('owner', $database->getUser(array('userID' => $list['account_id'])));
$page->assign('list', $list);
$page->display('list.tpl');

?>