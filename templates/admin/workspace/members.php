<h2><?php echo f('controller.name') ?> Members</h2>

<form method="post">
    <div>
        <input type="text" name="members[]" placeholder="Username of member">
    </div>
    <?php if (!empty($entry['members'])): ?>

        <?php foreach ($entry['members'] as $member): ?>
            <div>
                <input type="text" name="members[]" value="<?php echo $member ?>">
            </div>
        <?php endforeach ?>

    <?php endif ?>

    <div class="command-bar">
        <input type="submit">
        <a href="<?php echo \URL::site('/admin/workspace') ?>">List</a>
    </div>
</form>