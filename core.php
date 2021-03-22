<?

// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('phpmailer/PHPMailer.php');
require_once('phpmailer/SMTP.php');
require_once('phpmailer/Exception.php');
require_once('Smarty.class.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    
session_start();

$config = json_decode(file_get_contents('config.json'), true);

function createPage($database) {
    global $config;
    $page = new Smarty();
    $page->setCompileDir('templates_c');
    $page->assign('baseUrl', $config['baseUrl']);
    $page->assign('config', $config);
    if (isset($_SESSION['userID'])) {
        $page->assign('user', $database->getUser(array('userID' => $_SESSION['userID'])));
    }
    return $page;
}

function message($database, $type, $title, $message) {
    $page = createPage($database);
    $page->assign('type', $type);
    $page->assign('title', $title);
    $page->assign('message', $message);
    $page->display('message.tpl');
    die();
}

function mustHaveParameters($names) {
    foreach ($names as $name) {
        if (!isset($_REQUEST[$name])) {
            message($database, 'error', 'Invalid Parameters', 'Invalid set of parameters specified.');
        }
    }
}

function mustBeLoggedIn() {
    if (!$_SESSION['userName'] || !$_SESSION['userID']) {
        header('Location: /gifts/login?returnUrl='.urlEncode("$_SERVER[REQUEST_URI]"));
        die();
    }
}

function mustBeFriendOf($database, $userID) {
    if ($_SESSION['userID'] == $userID) {
        return;
    }
    $friends = $database->getFriends(array('userID' => $_SESSION['userID']));
    foreach ($friends as $friend) {
        if ($friend['id'] == $userID) {
            return;
        }
    }
    $page = createPage($database);
    $page->assign('owner', $database->getUser(array('userID' => $userID)));
    $page->display('accessDenied.tpl');
    die();
}

function mustHaveAccessToList($database, $listID) {
    $list = $database->getList(array('listID' => $listID));
    if ($_SESSION['userID'] == $list['account_id']) {
        return;
    }
    if ($list['visibility'] == 'private') {
        $page = createPage($database);
        $page->display('accessDenied.tpl');
        die();
    }
}

function mustBeOwnerOfList($database, $userID, $listID) {
    $list = $database->getList(array('listID' => $listID));
    if ($list['account_id'] != $userID) {
        message($database, 'error', 'Security Issue', 'You are not the owner of that list.');
    }
}

function mustNotBeNull($database, $o, $title, $message) {
    if ($o == null) {
        message($database, 'error', $title, $message);
    }
}

function sendEmail($database, $subject, $body, $recipients, $debug = false) {
    global $config;

    $emailConfig = $config['email'];
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->IsHTML(true);
    $mail->Host = $emailConfig['host'];
    $mail->Port = $emailConfig['port'];
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig['userName'];
    $mail->Password = $emailConfig['password'];
    $mail->setFrom($emailConfig['fromAddress'], $emailConfig['fromName']);

    $mail->Subject = $subject;
    $mail->Body = $body;
    foreach ($recipients as $recipient) {
        $mail->addAddress($recipient['address'], $recipient['name']);
    }

    if (!$mail->send() && $debug) {
        message($database, 'error', 'Could Not Send Email', 'An email could not be sent: '.$mail->ErrorInfo);
    }
}

?>