<aside class="side-menu-inner">
    <nav>
        <ul class="menu large-vertical horizontal">
            <?php foreach($items as $key => $item): ?>
                <li><a href="<?= base_url($item['url']) ?>"><i class="<?= $item['icon'] ?>"></i> <?= $key ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</aside>