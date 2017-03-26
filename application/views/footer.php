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
<footer>
    <!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr style="background:#eeeeee;"><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/rs/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/rs/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/bdg_now_accepting_pp_2line_w.png" border="0" alt="Now accepting PayPal"></a><div style="text-align:center"><a href="https://www.paypal.com/rs/webapps/mpp/pay-online" target="_blank" ><font size="2" face="Arial" color="#0079CD"><b>How PayPal Works</b></font></a></div></td></tr></table><!-- PayPal Logo -->
</footer>
<script src="<?= base_url(); ?>application/assets/js/vendor/jquery.js"></script>
<script src="<?= base_url(); ?>application/assets/js/vendor/foundation.min.js"></script>
<script src="<?= base_url(); ?>application/assets/js/vendor/socket-io.js"></script>
<script src="<?= base_url(); ?>application/assets/js/app.js"></script>
</body>
</html>