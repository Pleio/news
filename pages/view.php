<?php

$guid = get_input('guid');

if ($guid) {
    $entity = get_entity($guid);
}

elgg_push_context('news');
elgg_set_page_owner_guid($entity->guid);

if (!$entity) {
    system_error(elgg_echo('news:could_not_find'));
    forward(REFERER);
}

if ($entity->canEdit()) {
    elgg_register_title_button('news', 'edit');
}

$title = $entity->title;
$body = elgg_view_layout('content', array(
    'title' => $entity->title,
    'filter' => '',
    'content' => elgg_view_entity($entity, array(
        'full_view' => true
    ))
));

echo elgg_view_page($title, $body, "default", array(
    'leader' => elgg_view('news/header', array(
        'entity' => $entity
    ))
));
