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
                    <h1>Settings</h1>
                    <h2>General</h2>
                    <?php echo form_open('backoffice/settings/save'); ?>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Currency
                                <input type="text" placeholder="Currency" name="settings[currency]" value="<?= isset($settings->currency) ? $settings->currency : '' ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Currency symbol
                                <input type="text" placeholder="Currency" name="settings[currency_symbol]" value="<?= isset($settings->currency_symbol) ? $settings->currency_symbol : '' ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-4 columns">
                            <label>Initial duration (Seconds)
                                <input type="number" placeholder="Initial duration" name="settings[initial_duration]" value="<?= isset($settings->initial_duration) ? $settings->initial_duration : '' ?>">
                            </label>
                        </div>
                        <div class="medium-4 columns">
                            <label>Going once duration (Seconds)
                                <input type="number" placeholder="Going once duration" name="settings[going_once]" value="<?= isset($settings->going_once) ? $settings->going_once : '' ?>">
                            </label>
                        </div>
                        <div class="medium-4 columns">
                            <label>Going twice duration (Seconds)
                                <input type="number" placeholder="Going twice duration" name="settings[going_twice]" value="<?= isset($settings->going_twice) ? $settings->going_twice : '' ?>">
                            </label>
                        </div>
                    </div>
                    <h2>Automatic bidding</h2>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Lowest automatic sale
                                <input type="number" placeholder="Lowest automatic sale" name="settings[lowest_sale]" value="<?= isset($settings->lowest_sale) ? $settings->lowest_sale : '' ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Highest automatic sale
                                <input type="number" placeholder="Highest automatic sale" name="settings[highest_sale]" value="<?= isset($settings->highest_sale) ? $settings->highest_sale : '' ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Smallest number of bids
                                <input type="number" placeholder="Smallest number of bids" name="settings[bids_low]" value="<?= isset($settings->bids_low) ? $settings->bids_low : '' ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Largest number of bids
                                <input type="number" placeholder="Largest number of bids" name="settings[bids_high]" value="<?= isset($settings->bids_high) ? $settings->bids_high : '' ?>">
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