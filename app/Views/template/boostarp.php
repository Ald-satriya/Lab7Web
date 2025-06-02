<?php if ($pager->hasPreviousPage()): ?>
    <a href="<?= $pager->getPreviousPage() ?>" data-ci-pagination-page="<?= $pager->getPreviousPageNumber() ?>">Sebelumnya</a>
<?php endif ?>

<?php foreach ($pager->links() as $link): ?>
    <a href="<?= $link['uri'] ?>" data-ci-pagination-page="<?= $link['title'] ?>" class="<?= $link['active'] ? 'active' : '' ?>">
        <?= $link['title'] ?>
    </a>
<?php endforeach ?>

<?php if ($pager->hasNextPage()): ?>
    <a href="<?= $pager->getNextPage() ?>" data-ci-pagination-page="<?= $pager->getNextPageNumber() ?>">Selanjutnya</a>
<?php endif ?>
