<?php

$site = elgg_get_site_entity();

elgg_push_context('news');
elgg_set_page_owner_guid($site->guid);

if ($site->canWriteToContainer(0, 'object', 'news')) {
    elgg_register_title_button();
}

$options = array(
    'type' => 'object',
    'subtype' => 'news',
    'full_view' => false
);

$title = elgg_echo('news');

$content = elgg_view('news/all_extend') . elgg_list_entities($options);

$body = elgg_view_layout('content', array(
    'title' => $title,
    'filter' => '',
    'content' => $content
));

echo elgg_view_page($title, $body);
