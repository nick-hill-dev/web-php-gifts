<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('friendID'));

$database = new Database($config);
$giftID = $database->deleteFriendRequest(array('userID' => $_SESSION['userID'], 'friendID' => $_GET['friendID']));

header('Location: '.$config['baseUrl'].'/myLists');

?>