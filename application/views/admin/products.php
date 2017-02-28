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
                <th>Title</th>
                <th>Stock</th>
                <th>Start Price</th>
                <th>Publish</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($products as $key => $product): ?>
                <tr>
                    <td><?= $product->product_title; ?></td>
                    <td><?= $product->stock; ?></td>
                    <td><?= $product->initial_price; ?></td>
                    <td><a href="<?= base_url('backoffice/products/edit/'.$product->id) ?>" class="button primary small expanded">Edit</a></td>
                    <?php if ($product->published == 1): ?>
                        <td><a href="<?= base_url('backoffice/products/unpublish/'.$product->id) ?>" class="button warning small expanded">Published (Unpublish)</a></td>
                    <?php else: ?>
                        <td><a href="<?= base_url('backoffice/products/publish/'.$product->id) ?>" class="button secondary small expanded">Unpublished (Publish)</a></td>
                    <?php endif; ?>
                    <td><a href="<?= base_url('backoffice/products/delete/'.$product->id) ?>" class="button alert small expanded" onclick="return confirm('This cannot be undone')">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">

        </div>
    </div>
</div>