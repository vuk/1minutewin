<section class="center">
    <div class="row">
        <div class="columns large-12 small-12">
            <article class="page">
                <h1>Cart</h1>

                <div class="content">
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
                    <ul class="tabs" data-deep-link="true" data-tabs id="deeplinked-tabs">
                        <li class="tabs-title is-active"><a href="#bought" aria-selected="true">Bought</a></li>
                        <li class="tabs-title"><a href="#paid">Paid</a></li>
                        <li class="tabs-title"><a href="#delivered">Delivered</a></li>
                    </ul>

                    <div class="tabs-content" data-tabs-content="deeplinked-tabs">
                        <div class="tabs-panel is-active" id="bought">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($bought as $key => $order): ?>
                                        <tr>
                                            <td><?= $order->id ?></td>
                                            <?php if (isset($order->product->id)): ?>
                                            <td><?= $order->product->product_title ?></td>
                                            <?php else: ?>
                                                <td>Product was deleted</td>
                                            <?php endif; ?>
                                            <td><?= $settings->currency_symbol.number_format($order->winning_price, 2) ?></td>
                                            <td><a target="_blank" href="<?= base_url('pay/pay/'.$order->id) ?>"><i class="fa fa-cc-paypal" aria-hidden="true"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tabs-panel" id="paid">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($paid as $key => $order): ?>
                                    <tr>
                                        <td><?= $order->id ?></td>
                                        <?php if (isset($order->product->id)): ?>
                                            <td><?= $order->product->product_title ?></td>
                                        <?php else: ?>
                                            <td>Product was deleted</td>
                                        <?php endif; ?>
                                        <td><?= $settings->currency_symbol.number_format($order->winning_price, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tabs-panel" id="delivered">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <?php foreach($delivered as $key => $order): ?>
                                    <tr>
                                        <td><?= $order->id ?></td>
                                        <?php if (isset($order->product->id)): ?>
                                            <td><?= $order->product->product_title ?></td>
                                        <?php else: ?>
                                            <td>Product was deleted</td>
                                        <?php endif; ?>
                                        <td><?= $settings->currency_symbol.number_format($order->winning_price, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>