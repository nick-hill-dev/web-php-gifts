<?

require_once('core.php');

$database = new Database($config);
$page = createPage($database);
    
if (!isset($_POST['userName'])) {
    $page->display('register.tpl');
    die();
}

$database->registerAccount($_POST);
$details = $database->login(array('userName' => $_POST['userName'], 'password' => $_POST['password']));
$_SESSION['userName'] = $_POST['userName'];
$_SESSION['userID'] = $details['accountID'];

header('Location: '.$config['baseUrl'].'/myLists');

?>