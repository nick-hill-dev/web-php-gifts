<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('friendID'));

$database = new Database($config);
$giftID = $database->deleteFriendRequest(array('userID' => $_GET['friendID'], 'friendID' => $_SESSION['userID']));

header('Location: '.$config['baseUrl'].'/myLists');

?>