<section class="center">
    <div class="row">
        <div class="columns large-12 small-12">
            <article class="product-wrapper small-12 large-4 medium-10">
                <div class="product-inner" style="padding: 20px;">
                    <div class="panel" style="width: 100%;">
                        <?php echo form_open('auth/registration'); ?>
                        <fieldset class="fieldset">
                            <legend>Register</legend>
                            <?php if(isset($error)):  ?>
                                <div class="callout alert" data-closable>
                                    <p style="margin: 0;"><?= $error ?></p>
                                    <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <label> First name
                                <input type="text" placeholder="First name" name="first_name">
                            </label>
                            <label> Last name
                                <input type="text" placeholder="Last name" name="last_name">
                            </label>
                            <label> Email Address
                                <input type="email" placeholder="Email Address" name="email">
                            </label>
                            <label> Password
                                <input type="password" placeholder="Password" name="password">
                            </label>
                            <div class="row collapse">
                                <label>
                                    <input type="submit" class="button expanded" value="Register">
                                </label>
                            </div>
                            <div class="row collapse">
                                <div class="columns medium-6">
                                    <a href="<?= base_url('auth/social/facebook') ?>" class="button expanded facebook">
                                        <i class="fa fa-facebook" aria-hidden="true"></i> Facebook
                                    </a>
                                </div>
                                <div class="columns medium-6">
                                    <a href="<?= base_url('auth/social/google') ?>" class="button expanded google">
                                        <i class="fa fa-google" aria-hidden="true"></i> Google
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>