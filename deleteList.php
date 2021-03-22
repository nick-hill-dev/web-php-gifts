<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('listID'));

$database = new Database($config);
mustBeOwnerOfList($database, $_SESSION['userID'], $_GET['listID']);

$database->deleteList(array('listID' => $_GET['listID']));
header('Location: '.$config['baseUrl'].'/myLists');

?>