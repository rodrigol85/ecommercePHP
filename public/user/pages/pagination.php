<?php 

include 'controllo.php';

?> 
<?php
function generatePagination($page, $pages) {
    ob_start(); ?>
    <nav aria-label="Page navigation example ">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page === 1 ? 'disabled' : ''; ?>">
                <a href="<?= $page > 1 ? '?page=products&p=' . ($page - 1) : '#'; ?>" aria-label="Previous" class="page-link">
                    <span aria-hidden="true">&laquo; Previous</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                <li class="page-item <?php echo ($page === $i) ? 'active' : ''; ?>">
                    <a href="?page=products&p=<?= $i; ?>" class="page-link"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page === $pages ? 'disabled' : ''; ?>">
                <a href="<?= $page < $pages ? '?page=products&p=' . ($page + 1) : '#'; ?>" aria-label="Next" class="page-link">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <?php
    return ob_get_clean();
}
