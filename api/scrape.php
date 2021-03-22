<?

$url = $_GET['url'];
$details = parse_url($url);
$result = array('title' => $url, 'type' => 'webPage', 'images' => array());

header('Content-type: application/json');

$ext = pathinfo($url, PATHINFO_EXTENSION);

if ($ext == 'jpg' || $ext == 'png' || $ext = 'gif') {
    $result['type'] = 'image';
    $result['images'][] = $url;
    die(json_encode($result));
}

$html = file_get_contents($url);
if ($html == '') {
    http_status_code(500);
    die();
}

preg_match("/<title>(.*)<\/title>/siU", $html, $titleMatches);
$title = $titleMatches[1];
$result['title'] = trim($title);

$urls = array();
$foundAmazon = false;
if ($details['host'] == 'www.amazon.co.uk') {
    preg_match('|data-a-dynamic-image=\"{&quot;([^&]+)|i', $html, $amazonImageMatches);
    for ($i = 1; $i < count($amazonImageMatches); $i++) {
        $match = $amazonImageMatches[$i];
        if (!in_array($match, $urls)) {
            $urls[] = $match;
        }
        $foundAmazon = true;
    }
}

if (!$foundAmazon) {
    preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $html, $matches);
    foreach ($matches[1] as $match) {
        if (substr($match, 0, 2) != '//') {
            if (substr($match, 0, 1) == '/') {
                $url = $details['scheme'].'://'.$details['host'].$match;
            } else if ($match != '' && (substr($match, 0, 5) != 'data:') && (substr($match, 0, 2) != '<#')) {
                $url = $match;
            }
            if (!in_array($url, $urls)) {
                $urls[] = trim($url);
            }
        }
    }
}
$result['images'] = $urls;
die(json_encode($result));

?>