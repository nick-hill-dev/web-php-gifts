<?

require_once('core.php');

$database = new Database($config);

$page = createPage($database);
    
if (!isset($_POST['userName']) || !isset($_POST['password'])) {
    $page->display('login.tpl');
    die();
}

$details = $database->login($_POST);
if (!$details) {
    $page->assign('errorMessage', 'The specified username or password is incorrect.');
    $page->display('login.tpl');
    die();
}

$_SESSION['userName'] = $_POST['userName'];
$_SESSION['userID'] = $details['accountID'];
if (isset($_GET['returnUrl'])) {
    header('Location: '.$_GET['returnUrl']);
} else {
    header('Location: '.$config['baseUrl'].'/myLists');
}

?>