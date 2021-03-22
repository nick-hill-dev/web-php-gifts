<?

require_once('core.php');

mustBeLoggedIn();
mustHaveParameters(array('friendID'));

$database = new Database($config);
$valid = true;
$existingFriends = $database->getFriends(array('userID' => $_SESSION['userID']));
foreach ($existingFriends as $existingFriend) {
    if ($existingFriend['id'] == $_GET['friendID']) {
        $valid = false;
    }
}

$existingRequests = $database->getFriendRequests(array('userID' => $_SESSION['userID']));
foreach ($existingRequests['forOthers'] as $existingRequest) {
    if ($existingRequest['id'] == $_GET['friendID']) {
        $valid = false;
    }
}

$friend = $database->getUser(array('userID' => $_GET['friendID']));
if ($friend == null || $_GET['friendID'] == $_SESSION['userID']) {
    $valid = false;
}

if (!$valid) {
    message($database, 'error', 'Invalid Friend Request', 'You cannot add that person as a friend.');
}

$database->addFriendRequest(array('requestingFriendID' => $_SESSION['userID'], 'requestedFriendID' => $_GET['friendID']));

header('Location: '.$config['baseUrl'].'/myLists');

$me = $database->getUser(array('userID' => $_SESSION['userID']));
$myFullName = $me['first_name'].' '.$me['last_name'];
$theirFullName = $friend['first_name'].' '.$friend['last_name'];
$title = $myFullName.' wants to be your friend on GiftMouse!';
$url = "https://$_SERVER[HTTP_HOST]$config[baseUrl]/myLists";
sendEmail($database, $title, "<p>$title</p>".'<p><a href="'.$url.'">Click here to review your friend requests on GiftMouse.</a></p>', array(array('address' => $friend['email'], 'name' => $theirFullName)));

?>