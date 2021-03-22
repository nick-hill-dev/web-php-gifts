<?

require_once('core.php');

mustBeLoggedIn();

$database = new Database($config);

$page = createPage($database);

if (!isset($_POST['friendName'])) {
    
    $page->display('friendSearchStart.tpl');
    
} else {
    
    $page->assign('searchTerm', $_POST['friendName']);
    $page->assign('searchResults', $database->searchForFriends(array('userID' => $_SESSION['userID'], 'term' => $_POST['friendName'])));
    $page->display('friendSearchResults.tpl');
    
}

?>