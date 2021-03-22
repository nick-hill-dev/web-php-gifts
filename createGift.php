<?

require_once('core.php');

$database = new Database($config);
$page = createPage($database);
$listID = $_GET['listID'];

mustBeLoggedIn();
mustHaveParameters(array('listID'));
mustBeOwnerOfList($database, $_SESSION['userID'], $listID);

if (!isset($_POST['title'])) {
    $page->assign('list', $database->getList(array('listID' => $listID)));
    $page->display('createGift.tpl');
    die();
}

$giftID = $database->createGift(array('listID' => $listID, 'title' => $_POST['title'], 'notes' => $_POST['notes']));
if (isset($_POST['url']) && trim($_POST['url']) != '') {
    $database->createGiftLink(array('giftID' => $giftID, 'pageUrl' => $_POST['url'], 'pageTitle' => $_POST['pageTitle'], 'imageUrl' => $_POST['imageUrl']));
}
header('Location: '.$config['baseUrl'].'/lists/'.$listID);

?>