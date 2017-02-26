<section class="center">
    <div class="row">
        <div class="columns large-4 large-offset-4 medium-10 medium-offset-1 small-12">
            <div class="panel admin-login">
                <?php echo form_open('backoffice/login/signin'); ?>
                    <fieldset class="fieldset">
                        <legend>Administrative login</legend>
                        <?php if(isset($error)):  ?>
                            <div class="callout alert" data-closable>
                                <p style="margin: 0;"><?= $error ?></p>
                                <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <label>
                            <input type="email" placeholder="Email Address" name="email">
                        </label>
                        <label>
                            <input type="password" placeholder="Password" name="password">
                        </label>
                        <label>
                            <input type="submit" class="button expanded" value="Login">
                        </label>
                    </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>