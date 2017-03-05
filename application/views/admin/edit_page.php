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
                    <h1>New page</h1>
                    <?php echo form_open('backoffice/pages/update'); ?>
                    <input type="hidden" value="<?= $page->id ?>" name="page_id">
                    <div class="row">
                        <div class="columns medium-12">
                            <label>Page title
                                <input type="text" placeholder="Page title" name="page_title" value="<?= $page->page_title ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns medium-12">
                            <label>Permalink
                                <input type="text" placeholder="Permalink" name="slug" value="<?= $page->slug ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-12 columns">
                            <label>Page content
                                <textarea name="page_content" id="page_content" placeholder="Page content"><?= $page->page_content ?></textarea>
                            </label>
                            <script>
                                (function() {
                                    tinymce.init({
                                        selector: '#page_content',
                                        plugins: "link",
                                        min_height: 300,
                                        file_picker_types: 'file image media',
                                        images_upload_base_path: '/uploads/pages/',
                                        toolbar: 'undo redo | styleselect | bold italic underline | link image | alignleft aligncenter alignright'
                                    });
                                })();
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns medium-6">
                            <label>Font awesome icon
                                <input type="text" placeholder="Font awesome icon" name="fa_icon" value="<?= $page->fa_icon ?>">
                            </label>
                        </div>
                        <div class="columns medium-6">
                            <label>Display in menu
                                <select name="show_menu" id="">
                                    <option value="0" <?= $page->show_menu == 0 ? "selected='selected'" : ""?>>Don't display</option>
                                    <option value="1" <?= $page->show_menu == 1 ? "selected='selected'" : ""?>>Display</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-12 columns">
                            <label style="margin-top: 20px;">
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