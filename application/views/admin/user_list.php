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
        <table>
            <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $key => $user): ?>
            <tr>
                <td><?= $user->first_name; ?></td>
                <td><?= $user->last_name; ?></td>
                <td><a href="<?= base_url('backoffice/usermanagement/edit/'.$user->id) ?>" class="button primary small expanded">Edit</a></td>
                <?php if ($user->active == 1): ?>
                    <td><a href="<?= base_url('backoffice/usermanagement/deactivate/'.$user->id) ?>" class="button warning small expanded">Active (Deactivate)</a></td>
                <?php else: ?>
                    <td><a href="<?= base_url('backoffice/usermanagement/activate/'.$user->id) ?>" class="button secondary small expanded">Inactive (Activate)</a></td>
                <?php endif; ?>
                <td><a href="<?= base_url('backoffice/usermanagement/delete/'.$user->id) ?>" class="button alert small expanded" onclick="return confirm('This cannot be undone')">Delete</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">

        </div>
    </div>
</div>