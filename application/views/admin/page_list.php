<div class="row">
    <div class="columns large-12 small-12">
        <?php if(isset($error)):  ?>
            <div class="callout alert" data-closable>
                <p style="margin: 0;"><?= $error ?></p>
                <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if(isset($success)):  ?>
            <div class="callout success" data-closable>
                <p style="margin: 0;"><?= $success ?></p>
                <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($pages as $key => $page): ?>
                <tr>
                    <td><?= $page->id; ?></td>
                    <td><a href="<?= base_url().$page->slug ?>">
                            <?= $page->page_title; ?></a>
                    </td>
                    <td><a href="<?= base_url('backoffice/pages/edit/'.$page->id) ?>" class="button primary small expanded">Edit</a></td>
                    <td><a href="<?= base_url('backoffice/pages/delete/'.$page->id) ?>" class="button alert small expanded" onclick="return confirm('This cannot be undone')">Delete page</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <ul>
                <?php
                foreach ($pageLinks as $key => $link):
                    ?>
                    <li><a href="<?= $link ?>"><?= $key ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>