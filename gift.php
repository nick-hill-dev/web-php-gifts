<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('id'));

$database = new Database($config);
$gift = $database->getGift(array('giftID' => $_GET['id']));
mustNotBeNull($database, $gift, 'Gift Deleted', 'This gift has been deleted from the list.');
$list = $database->getList(array('listID' => $gift['list_id']));

$lists = $database->getLists(array('accountID' => $list['account_id']));

mustBeFriendOf($database, $list['account_id']);
mustHaveAccessToList($database, $list['id']);

$purchasedByMe = false;
foreach ($gift['purchases'] as $purchase) {
    if ($purchase['user_id'] == $_SESSION['userID']) {
        $purchasedByMe = true;
    }
}

$searchString = urlEncode($gift['title']);

$page = createPage($database);
$page->assign('owner', $database->getUser(array('userID' => $list['account_id'])));
$page->assign('lists', $lists);
$page->assign('list', $list);
$page->assign('gift', $gift);
$page->assign('purchasedByMe', $purchasedByMe);
$page->assign('searchString', $searchString);
$page->display('gift.tpl');

?>