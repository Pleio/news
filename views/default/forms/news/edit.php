<?php
gatekeeper();

$entity = elgg_extract("entity", $vars);

if ($entity) {
    echo elgg_view("input/hidden", array("name" => "guid", "value" => $entity->guid));
    $titles = $entity->titles;
    $urls = $entity->urls;
} else {
    $titles = array();
    $urls = array();
}

$user = elgg_get_logged_in_user_entity();
$containers = array();
foreach ($user->getGroups(array(), 50) as $group) {
    $containers[$group->guid] = $group->name;
}

?>

<div>
    <label for="title"><?php echo elgg_echo("news:title"); ?></label><br />
    <div>
    <?php echo elgg_view('input/text', array(
        'name' => 'title',
        'value' => elgg_get_sticky_value('news', 'title', $entity->title)
    )); ?>
    </div>
</div><br />

<div>
    <label for="description"><?php echo elgg_echo("news:description"); ?></label><br />
    <div>
    <?php echo elgg_view('input/longtext', array(
        'name' => 'description',
        'value' => elgg_get_sticky_value('news', 'description', $entity->description)
    )); ?>
    </div>
</div><br />

<div>
    <label for="container_guid"><?php echo elgg_echo("news:container"); ?></label><br />
    <div>
    <?php echo elgg_view('input/dropdown', array(
        'name' => 'container_guid',
        'options_values' => $containers,
        'value' => elgg_get_sticky_value('news', 'container_guid', $entity->container_guid)
    )); ?>
    </div>
</div><br />

<div>
    <label for="header"><?php echo elgg_echo("news:header"); ?></label><br />
    <div>
    <?php echo elgg_view('input/file', array(
        'name' => 'header'
    )); ?>
    </div>
</div><br />

<div>
    <label for="tags"><?php echo elgg_echo("tags"); ?></label><br />
    <?php echo elgg_view('input/tags', array(
        'name' => 'tags',
        'value' => elgg_get_sticky_value('news', 'tags', $entity->tags)
    )); ?>
</div><br />

<div>
    <label for="tags"><?php echo elgg_echo("access"); ?></label><br />
    <?php echo elgg_view('input/access', array(
        'name' => 'access_id',
        'value' => ($entity->access_id) ? $entity->access_id : get_default_access()
    )); ?>
</div><br />

<?php
echo elgg_view("input/submit", array(
    'value' => ($entity) ? elgg_echo('edit') : elgg_echo('add')
));

if ($entity) {
    echo elgg_view("output/confirmlink", array(
        'text' => elgg_echo('delete'),
        'href' => '/action/news/delete?guid=' . $entity->guid,
        'class' => 'elgg-button elgg-button-delete',
        'is_action' => true
    ));
}