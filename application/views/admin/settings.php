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
                    <?php echo form_open('backoffice/settings/save'); ?>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Currency
                                <input type="text" placeholder="Currency" name="settings[currency]" value="<?= $settings->currency ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Currency symbol
                                <input type="text" placeholder="Currency" name="settings[currency_symbol]" value="<?= $settings->currency_symbol ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-4 columns">
                            <label>Initial duration (Seconds)
                                <input type="number" placeholder="Initial duration" name="settings[initial_duration]" value="<?= $settings->initial_duration ?>">
                            </label>
                        </div>
                        <div class="medium-4 columns">
                            <label>Going once duration (Seconds)
                                <input type="number" placeholder="Going once duration" name="settings[going_once]" value="<?= $settings->going_once ?>">
                            </label>
                        </div>
                        <div class="medium-4 columns">
                            <label>Going twice duration (Seconds)
                                <input type="number" placeholder="Going twice duration" name="settings[going_twice]" value="<?= $settings->going_twice ?>">
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