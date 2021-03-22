<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('friendID'));

if ($_GET['friendID'] == $_SESSION['userID']) {
    die('Invalid request.');
}

$database = new Database($config);
$giftID = $database->unfriend(array('userID' => $_GET['friendID'], 'friendID' => $_SESSION['userID']));
$giftID = $database->unfriend(array('userID' => $_SESSION['userID'], 'friendID' => $_GET['friendID']));

header('Location: '.$config['baseUrl'].'/myLists');

?>