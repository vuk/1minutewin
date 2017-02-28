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
                    <h1>Edit user</h1>
                    <?php echo form_open('usermanagement/update'); ?>
                    <input type="hidden" name="user_id" value="<?= $user->id ?>">
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>First name
                                <input type="text" placeholder="First name" name="first_name" value="<?= $user->first_name ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>Last name
                                <input type="text" placeholder="Last name" name="last_name" value="<?= $user->last_name ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <label>Email
                                <input type="email" placeholder="Email" name="email_address" value="<?= $user->email ?>">
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
                                <input type="text" placeholder="Promo Code" name="promo_code"  value="<?= $user->promo_code ?>">
                            </label>
                        </div>
                        <div class="medium-6 columns">
                            <label>User Level
                                <select name="user_level">
                                    <option <?php echo $user->user_level == 1 ? 'selected="selected"' : ''; ?> value="1">Administrator</option>
                                    <option <?php echo $user->user_level > 1 ? 'selected="selected"' : ''; ?> value="50">Regular user</option>
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