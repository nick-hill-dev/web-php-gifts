<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('giftID'));

$database = new Database($config);
$gift = $database->getGift(array('giftID' => $_GET['giftID']));
$list = $database->getList(array('listID' => $gift['list_id']));
mustBeOwnerOfList($database, $_SESSION['userID'], $list['id']);

if (isset($_POST['newNotes'])) {
    $database->editGift(array('giftID' => $_GET['giftID'], 'title' => $_POST['newTitle'], 'notes' => $_POST['newNotes']));
}

if (isset($_POST['url']) && trim($_POST['url']) != '') {
    $database->createGiftLink(array('giftID' => $_GET['giftID'], 'pageUrl' => $_POST['url'], 'pageTitle' => $_POST['pageTitle'], 'imageUrl' => $_POST['imageUrl']));
}

header('Location: '.$config['baseUrl'].'/lists/'.$list['id'].'/gifts/'.$_GET['giftID']);

?>