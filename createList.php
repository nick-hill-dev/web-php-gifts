<?

require_once('core.php');

mustBeLoggedIn();

$database = new Database($config);
$page = createPage($database);

if (!isset($_POST['name'])) {
    $page->display('createList.tpl');
    die();
}

$id = $database->createList(array('accountID' => $_SESSION['userID'], 'name' => $_POST['name'], 'visibility' => $_POST['visibility']));
header('Location: '.$config['baseUrl'].'/lists/'.$id);

?>