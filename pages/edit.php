<?php

$guid = get_input('guid');

if ($guid) {
    $news = get_entity($guid);
    if (!$news | !$news instanceof Elggnews) {
        register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
        forward(REFERER);
    }
}

$options = array(
        'name' => 'news',
        'action' => 'action/news/save',
        'enctype' => 'multipart/form-data'
);

$content = elgg_view_form(
    'news/edit', $options, array(
        'entity' => $news
    )
);

if ($guid) {
    $title = elgg_echo('news:edit');
} else {
    $title = elgg_echo('news:add');
}

$content = elgg_view_layout('content', array(
    'title' => $title,
    'filter' => '',
    'content' => $content
));

echo elgg_view_page($title, $content);