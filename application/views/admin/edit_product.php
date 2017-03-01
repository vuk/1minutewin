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
                    <h1>Edit product</h1>
                    <?php echo form_open_multipart('backoffice/products/update'); ?>
                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Product title
                                <input type="text" placeholder="Product title" name="product_title" value="<?= $product->product_title ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Stock
                                <input type="number" placeholder="Stock" name="stock" value="<?= $product->stock ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Shipping price
                                <input type="number" step="0.01" placeholder="Shipping price" name="shipping_price" value="<?= $product->shipping_price ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Shipping
                                <input type="text" placeholder="Shipping description" name="shipping" value="<?= $product->shipping ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Initial price
                                <input type="number" step="0.01" placeholder="Initial price" name="initial_price" value="<?= $product->initial_price ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label for="">
                                Upload images
                                <input id="fileupload" type="file" name="files[]" multiple>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-12 columns">
                            <label>Product description
                                <textarea placeholder="Product description" name="product_description"><?= $product->product_description ?></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                            <?php
                            if (sizeof(json_decode($product->pictures)) > 0):
                            foreach (json_decode($product->pictures) as $picture):
                                $pictureArray = explode('/', $picture);
                                ?>
                                <div class="large-3 columns small-6 medium-4">
                                    <img style="width: 100px;" src="<?= base_url($picture); ?>"/><br/>
                                    <a href="<?= base_url('backoffice/products/deleteimage/'.$product->id.'/'.$pictureArray[0].'/'.$pictureArray[1].'/'.urlencode($pictureArray[2])) ?>">Delete</a>
                                </div>
                            <?php endforeach;endif; ?>
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