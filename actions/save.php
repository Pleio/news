<?php

$guid = get_input('guid');
$title = get_input('title');
$description = get_input('description');
$tags = string_to_tag_array(get_input('tags'));

$container_guid = (int) get_input('container_guid');
$access_id = (int) get_input('access_id');

$top_photo = get_input("top_photo");
$featured_photo = get_input("featured_photo");

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


if ($guid && $top_photo == "remove") {
    $fh = new ElggFile();
    $fh->owner_guid = $news->guid;
    $fh->setFilename("top_photo.jpg");
    $fh->delete();

    $news->topPhotoTime = null;
    $news->save();
} elseif (get_resized_image_from_uploaded_file("top_photo", 1280, 330)) {
    $fh = new ElggFile();
    $fh->owner_guid = $news->guid;
    $fh->setFilename("top_photo.jpg");
    $fh->open("write");

    $contents = get_resized_image_from_uploaded_file("top_photo", 1280, 330);
    $fh->write($contents);
    $fh->close();

    $news->topPhotoTime = time();
    $news->save();
}

if ($guid && $featured_photo == "remove") {
    $fh = new ElggFile();
    $fh->owner_guid = $news->guid;
    $fh->setFilename("featured_photo.jpg");
    $fh->delete();

    $news->featuredPhotoTime = null;
    $news->save();
} elseif (get_resized_image_from_uploaded_file("featured_photo", 649, 365)) {
    $fh = new ElggFile();
    $fh->owner_guid = $news->guid;
    $fh->setFilename("featured_photo.jpg");
    $fh->open("write");

    $contents = get_resized_image_from_uploaded_file("featured_photo", 649, 365);
    $fh->write($contents);
    $fh->close();

    $news->featuredPhotoTime = time();
    $news->save();
}


elgg_clear_sticky_form('news');

if ($guid) {
    system_message(elgg_echo('news:edited'));
    forward($news->getURL());
} else {
    system_message(elgg_echo('news:added'));
    forward('/news');
}
