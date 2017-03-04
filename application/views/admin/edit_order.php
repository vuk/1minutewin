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
        <div class="form-holder">
            <div class="row">
                <div class="columns large-12 small-12">
                    <h1>Edit order</h1>
                    <?php echo form_open('backoffice/orders/update'); ?>
                    <input type="hidden" name="order_id" value="<?= $order->id ?>">
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>User:
                                <a href="<?= base_url('backoffice/usermanagement/edit/'. $order->user->id) ?>"><?= $order->user->first_name . ' ' . $order->user->last_name ?></a>
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Product
                                <a href="<?= base_url('backoffice/products/edit/'. $order->product->id) ?>"><?= $order->product->product_title ?></a>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Winning price
                                <input type="number" placeholder="Winning price" name="winning_price" value="<?= $order->winning_price ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Status
                                <select name="status" id="status">
                                    <option <?= $order->status == 1 ? 'selected="selected"' : '' ?> value="1">Received</option>
                                    <option <?= $order->status == 5 ? 'selected="selected"' : '' ?> value="5">Processing</option>
                                    <option <?= $order->status == 10 ? 'selected="selected"' : '' ?> value="10">Shipped</option>
                                    <option <?= $order->status == 15 ? 'selected="selected"' : '' ?> value="15">Completed</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-12 columns">
                            <label>
                                <input type="submit" class="button primary expanded" value="Submit"/>
                            </label>
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>