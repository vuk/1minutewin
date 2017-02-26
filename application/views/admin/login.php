<section class="center">
    <div class="row">
        <div class="columns large-4 large-offset-4 medium-10 medium-offset-1 small-12">
            <div class="panel admin-login">
                <?php echo form_open('backoffice/login/signin'); ?>
                    <fieldset class="fieldset">
                        <legend>Administrative login</legend>

                        <label>
                            <input type="text" placeholder="Email Address">
                        </label>
                        <label>
                            <input type="password" placeholder="Password">
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