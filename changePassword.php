<?

require_once('core.php');

mustHaveParameters(array('source'));

$database = new Database($config);

if ($_GET['source'] == 'email') {
    if (!isset($_POST['userName']) || !isset($_POST['password']) || !isset($_POST['changeCode'])) {
        $page = createPage($database);
        $page->display('changePassword.tpl');
    } else {
        
        $user = $database->getUser(array('userName' => $_POST['userName']));
        $code = $database->getPasswordResetCode(array('userID' => $user['id']));
        if ($user == null || $code == null || $code != $_POST['changeCode']) {
            message($database, 'error', 'Invalid Details', 'Incorrect details were specified. Perhaps the password reset was requested too long ago? Please try again.');
        }
        
        $database->changePassword(array('userID' => $user['id'], 'password' => $_POST['password']));
        
        header('Location: '.$config['baseUrl'].'/login');
        
    }
} else {

    mustBeLoggedIn();
    
}

?>