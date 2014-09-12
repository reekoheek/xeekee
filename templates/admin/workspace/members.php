<h2><?php echo f('controller.name') ?> Members (<?php echo $entry->format() ?>)</h2>

<form method="post" role="form">
    <div class="form-group">
        <input type="text" name="members[]" placeholder="Username of member" class="form-input">
    </div>
    <?php if (!empty($entry['members'])): ?>

        <?php foreach ($entry['members'] as $member): ?>
            <div class="form-group">
                <input type="text" name="members[]" value="<?php echo $member ?>" placeholder="Username of member" class="form-input">
            </div>
        <?php endforeach ?>

    <?php endif ?>

    <p>
        <input type="submit" class="btn btn-primary">
        <a href="<?php echo \URL::site('/admin/workspace') ?>" class="btn btn-default">List</a>
    </p>
</form>