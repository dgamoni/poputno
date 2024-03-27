<?php

return;
$label = $_GET['label'];
$url = $_GET['url'];
$align = $_GET['align'];
$content = file_get_contents("https://widgets.getpocket.com/v1/button?align=center&count=horizontal&label=$label&url=$url");
$url_self = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
$link = '<link rel="stylesheet" type="text/css" href="' . $url_self . '/assets/css/button.css?v=6" />';
preg_match_all('/<link(.*) \/>/isU', $content, $matches);
$content = str_replace($matches[0][0], $link, $content);
echo $content;
