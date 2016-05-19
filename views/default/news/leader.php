<?php
$entity = $vars['entity'];
?>

<?php if ($entity->headertime): ?>
    <div style="background-image: url('<?php echo $entity->getHeaderURL(); ?>');" class="rhs-news-item__lead"></div>
<?php endif ?>