<?php
elgg_register_event_handler('init', 'system', 'news_init');

function news_init() {
    elgg_register_entity_type('object', 'news');
    elgg_register_page_handler('news', 'news_page_handler');

    elgg_register_action('news/save', dirname(__FILE__) . "/actions/save.php");
    elgg_register_action('news/delete', dirname(__FILE__) . "/actions/delete.php");

    elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'news_container_permissions_check');
}

function news_page_handler($segments) {
    switch($segments[0]) {
        case "add":
            include(dirname(__FILE__) . "/pages/edit.php");
            break;
        case "edit":
            set_input('guid', $segments[1]);
            include(dirname(__FILE__) . "/pages/edit.php");
            break;
        case "view":
            set_input('guid', $segments[1]);
            include(dirname(__FILE__) . "/pages/view.php");
            break;
        case "header":
            set_input('guid', $segments[1]);
            include(dirname(__FILE__) . "/pages/header.php");
            break;
        case "all":
        default:
            include(dirname(__FILE__) . "/pages/all.php");
            break;
    }

    return true;
}

function news_container_permissions_check($hook, $type, $return_value, $params) {
    $user = elgg_extract('user', $params);
    $container = elgg_extract('container', $params);
    $subtype = elgg_extract('subtype', $params);

    if (!$subtype == "news") {
        return $return_value;
    }

    if ($user && $user->isAdmin()) {
        return true;
    } else {
        return false;
    }
}