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
                <th>Order</th>
                <th>Product</th>
                <th>User</th>
                <th>Final price</th>
                <th>Time</th>
                <th>Edit</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($orders as $key => $order): ?>
                <tr>
                    <td><?= $order->id; ?></td>
                    <td><a href="<?= base_url('backoffice/products/edit/'.$order->product->id) ?>"><?= $order->product->product_title; ?></a></td>
                    <td><a href="<?= base_url('backoffice/usermanagement/edit/'.$order->user->id) ?>"><?= $order->user->first_name . ' ' . $order->user->last_name; ?></a></td>
                    <td><?= $settings->currency_symbol ?><?= number_format($order->winning_price, 2); ?></td>
                    <td><?= $order->created_at; ?></td>
                    <td><a href="<?= base_url('backoffice/orders/edit/'.$order->id) ?>" class="button primary small expanded">Edit</a></td>
                    <?php if ($order->status == 1): ?>
                        <td><a href="<?= base_url('backoffice/orders/processing/'.$order->id) ?>" class="button secondary small expanded">Received (Start Processing)</a></td>
                    <?php elseif($order->status == 5): ?>
                        <td><a href="<?= base_url('backoffice/orders/ship/'.$order->id) ?>" class="button warning small expanded">Processing (Ship)</a></td>
                    <?php elseif($order->status == 10): ?>
                        <td><a href="<?= base_url('backoffice/orders/complete/'.$order->id) ?>" class="button primary small expanded">Shipped (Complete)</a></td>
                    <?php elseif($order->status == 15): ?>
                        <td><a href="javascript:void(0)" class="button success small expanded">Completed</a></td>
                    <?php endif; ?>
                    <td><a href="<?= base_url('backoffice/orders/cancel/'.$order->id) ?>" class="button alert small expanded" onclick="return confirm('This cannot be undone')">Cancel order</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">

        </div>
    </div>
</div>