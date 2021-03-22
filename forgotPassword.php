<?

require_once('core.php');

$database = new Database($config);

$page = createPage($database);

if (isset($_POST['userName'])) {
    
    $user = $database->getUser(array('userName' => $_POST['userName']));
    if ($user == null || $user['email'] != $_POST['emailAddress']) {
        message($database, 'error', 'Password Reset', 'The specified username or password is incorrect.');
    }
    
    $code = mt_rand(100000, 1000000);
    $database->createPasswordResetCode(array('userID' => $user['id'], 'code' => $code));
    
    $url = "https://$_SERVER[HTTP_HOST]$config[baseUrl]/resetPassword";
    $message = '<p>You requested that your password be reset.</p><p><a href="'.$url.'">Click here to reset your password.</a></p><p>Note, you will need to specifify the following code to reset your password:</p><p><b>'.$code.'</b></p>';
    sendEmail($database, 'GiftMouse Password Reset', $message, array(array('address' => $user['email'], 'name' => $user['first_name'].' '.$user['last_name'])));
    
    message($database, 'info', 'Password Reset', 'An email has been sent to your email address with a link to reset your password.');
    
}

$page->display('forgotPassword.tpl');

?>