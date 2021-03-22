<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('listID'));

$database = new Database($config);
$list = $database->getList(array('listID' => $_GET['listID']));
mustBeOwnerOfList($database, $_SESSION['userID'], $_GET['listID']);

if (isset($_POST['newName'])) {
    $database->editList(array('listID' => $_GET['listID'], 'name' => $_POST['newName'], 'visibility' => $_POST['newVisibility']));
}

header('Location: '.$config['baseUrl'].'/lists/'.$list['id']);

?>