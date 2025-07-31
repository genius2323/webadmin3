<?php $pager->setSurroundCount(2); ?>
<?php
$query = $_GET;
unset($query['page']);
$queryStr = http_build_query($query);
$append = $queryStr ? ('&' . $queryStr) : '';
?>
<?php if ($pager->hasPrevious()): ?>
    <ul class="pagination-modern">
        <li><a href="<?= $pager->getFirst() . $append ?>" aria-label="First">&laquo;&laquo;</a></li>
        <li><a href="<?= $pager->getPrevious() . $append ?>" aria-label="Previous">&laquo;</a></li>
    <?php else: ?>
        <ul class="pagination-modern">
            <li class="disabled"><span>&laquo;&laquo;</span></li>
            <li class="disabled"><span>&laquo;</span></li>
        <?php endif; ?>
        <?php foreach ($pager->links() as $link): ?>
            <?php if ($link['active']): ?>
                <li class="active"><span><?= $link['title'] ?></span></li>
            <?php elseif ($link['uri']): ?>
                <li><a href="<?= $link['uri'] . $append ?>"><?= $link['title'] ?></a></li>
            <?php else: ?>
                <li class="disabled"><span><?= $link['title'] ?></span></li>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($pager->hasNext()): ?>
            <li><a href="<?= $pager->getNext() . $append ?>" aria-label="Next">&raquo;</a></li>
            <li><a href="<?= $pager->getLast() . $append ?>" aria-label="Last">&raquo;&raquo;</a></li>
        <?php else: ?>
            <li class="disabled"><span>&raquo;</span></li>
            <li class="disabled"><span>&raquo;&raquo;</span></li>
        <?php endif; ?>
        </ul>