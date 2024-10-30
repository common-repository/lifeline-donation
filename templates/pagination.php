<?php if ($paginator->hasPages()) : ?>

    <?php $paginator->setPath(get_permalink()) ?>

    <nav>
        <ul class="pagination">
            <!-- Previous Page Link -->
            <?php if ($paginator->onFirstPage()) : ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php esc_html_e('Previous', 'lifeline-donation') ?>">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            <?php else : ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo  esc_url($paginator->previousPageUrl()) ?>" rel="prev" aria-label="<?php esc_html_e('Previous', 'lifeline-donation') ?>">&lsaquo;</a>
                </li>
            <?php endif ?>

            <!-- Pagination Elements -->
            <?php foreach ($elements as $element) : ?>
                <!-- "Three Dots" Separator -->
                <?php if (is_string($element)) : ?>
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link"><?php echo $element ?></span></li>
                <?php endif ?>

                <!-- Array Of Links -->
                <?php if (is_array($element)) : ?>
                    <?php foreach ($element as $page => $url) : ?>
                        <?php if ($page == $paginator->currentPage()) : ?>
                            <li class="page-item active" aria-current="page"><span class="page-link"><?php echo $page ?></span></li>
                        <?php else : ?>
                            <li class="page-item"><a class="page-link" href="<?php echo $paginator->url($page) ?>"><?php echo $page ?></a></li>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>

            <!-- Next Page Link -->
            <?php if ($paginator->hasMorePages()) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $paginator->nextPageUrl() ?>" rel="next" aria-label="<?php esc_html_e('Next', 'lifeline-donation') ?>">&rsaquo;</a>
                </li>
            <?php else : ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php esc_html__('Next', 'lifeline-donation') ?>">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            <?php endif ?>
        </ul>
    </nav>
<?php endif ?>
