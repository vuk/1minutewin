<div class="row">
    <div class="columns large-12 small-12">
        <table>
            <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
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
                <td><a href="<?= base_url('backoffice/usermanagement/delete/'.$user->id) ?>" class="button alert small expanded" onclick="return confirm('This cannot be undone')">Delete</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?= $links ?>
        </div>
    </div>
</div>