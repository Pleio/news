<?php

$guid = get_input('guid');
$title = get_input('title');
$description = get_input('description');
$tags = get_input('tags');

$container_guid = (int) get_input('container_guid');
$access_id = (int) get_input('access_id');

elgg_make_sticky_form('news');

if ($guid) {
    $news = get_entity($guid);
    if (!$news || !$news instanceof ElggNews || !$news->canEdit()) {
        register_error(elgg_echo('InvalidParameterException:NoEntityFound'));
        forward(REFERER);
    }
} else {
    $news = new ElggNews();
}

if (!$title) {
    register_error(elgg_echo('news:title:missing'));
    forward(REFERER);
}

$news->title = $title;
$news->description = $description;

$news->container_guid = $container_guid;
$news->access_id = $access_id;
$news->tags = $tags;
$news->save();

if (get_resized_image_from_uploaded_file("header", 1280, 330)) {
    $fh = new ElggFile();
    $fh->owner_guid = $news->getGUID();
    $fh->setFilename("header.jpg");
    $fh->open("write");

    $contents = get_resized_image_from_uploaded_file("header", 1280, 330);
    $fh->write($contents);
    $fh->close();

    $news->headertime = time();
    $news->save();
}

elgg_clear_sticky_form('news');
system_message('news:added');
forward('/news');