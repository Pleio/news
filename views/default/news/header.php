<?php
$entity = $vars['entity'];
?>

<?php if ($entity->topPhotoTime): ?>
    <div style="background-image: url('<?php echo $entity->getTopPhotoURL(); ?>');" class="rhs-news-item__lead"></div>
<?php endif ?>