<?php

$guid = (int) get_input("guid");
$time = (int) get_input("time");

if ($guid) {
    $entity = get_entity($guid);
}

if (!$entity) {
    header("HTTP/1.1 404 Not Found");
    exit;
}

// If is the same ETag, content didn't changed.
$etag = md5($guid . $time);
if (isset($_SERVER["HTTP_IF_NONE_MATCH"])) {
    list ($etag_header) = explode("-", trim($_SERVER["HTTP_IF_NONE_MATCH"], "\""));
    if ($etag_header === $etag) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
}

$fh = new ElggFile();
$fh->owner_guid = $guid;
$fh->setFilename("header.jpg");

$filecontents = $fh->grabFile();

if ($filecontents) {
    $filesize = strlen($filecontents);
    header("Content-type: image/jpeg");
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
    header("Pragma: public");
    header("Cache-Control: public");
    header("Content-Length: $filesize");
    header("ETag: \"$etag\"");
    echo $filecontents;
    exit;
}

// something went wrong so 404
header("HTTP/1.1 404 Not Found");
exit;
