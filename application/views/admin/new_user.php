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
        <?php //if(isset($errors)):  ?>
            <div class="callout alert" data-closable>
                <p style="margin: 0;"><?= validation_errors() ?></p>
                <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php //endif; ?>
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
                    <h1>New user</h1>
                    <?php echo form_open('backoffice/usermanagement/save'); ?>

                    <div class="row">
                        <div class="medium-6 columns">
                            <label>First name
                                <input type="text" placeholder="First name" name="first_name">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Last name
                                <input type="text" placeholder="Last name" name="last_name">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Email
                                <input type="email" placeholder="Email" name="email_address">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Password
                                <input type="password" placeholder="Password" name="password_value">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Promo code
                                <input type="text" placeholder="Promo Code" name="promo_code">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>User Level
                                <select name="user_level">
                                    <option value="1">Administrator</option>
                                    <option value="50" selected="selected">Regular user</option>
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