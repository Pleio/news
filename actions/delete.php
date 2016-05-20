<?php

$guid = get_input('guid');

if ($guid) {
    $news = get_entity($guid);
}

if (!$news || !$news instanceof ElggNews || !$news->canEdit()) {
    register_error(elgg_echo('InvalidParameterException:NoEntityFound'));
    forward(REFERER);
}

$news->delete();

system_message(elgg_echo('news:deleted'));
forward('/news');