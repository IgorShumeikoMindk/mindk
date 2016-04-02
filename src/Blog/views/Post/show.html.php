<?php
$date = new \DateTime();
$date->setTimestamp(strtotime($post->date));
?>

<div class="row">
    <h1><?php echo $post->title ?></h1>

    <p class="small"><a href="/posts/<?php echo $post->id;?>/edit"><?php echo $date->format('F j, Y H:i:s') ?></a></p>
    <?php echo htmlspecialchars_decode($post->content) ?>
</div>
