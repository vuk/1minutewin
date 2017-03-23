<div class="reveal" id="animatedModal11" data-reveal data-close-on-click="true" data-animation-in="hinge-in-from-top" data-animation-out="hinge-out-from-top">
    <div class="panel">
        <?php echo form_open('auth/signin'); ?>
        <fieldset class="fieldset">
            <legend>Login</legend>
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
            <div class="row collapse">
                <label>
                    <input type="submit" class="button expanded" value="Login">
                </label>
            </div>
            <div class="row collapse">
                <label> You don't have an account yet?
                    <a href="<?= base_url('auth/register') ?>" class="button expanded">Register</a>
                </label>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
    <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<script src="<?= base_url(); ?>application/assets/js/vendor/jquery.js"></script>
<script src="<?= base_url(); ?>application/assets/js/vendor/foundation.min.js"></script>
<script src="<?= base_url(); ?>application/assets/js/vendor/socket-io.js"></script>
<script src="<?= base_url(); ?>application/assets/js/app.js"></script>
</body>
</html>