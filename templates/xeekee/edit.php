<h2>Edit</h2>

<form method="post">
    <div class="form-group">
        <label>Body</label>
        <textarea name="body" rows="20"><?php echo @$entry['body'] ?></textarea>
    </div>

    <p>
        <input type="submit" value="Save" class="btn btn-default">
        <a href="<?php echo \URL::current() ?>" class="btn btn-default">Show</a>
        <?php if ($entry->isWorkspace()): ?>
            <a href="<?php echo \URL::site('/admin/workspace/'.$entry->getWorkspace()->getId().'/update') ?>" class="btn btn-default">Update Workspace</a>
        <?php else: ?>
            <a href="<?php echo \URL::site('/admin/workspace/null/create').'?path='.$app->request->getPathInfo() ?>" class="btn btn-default">Create Workspace</a>
        <?php endif ?>
    </p>
</form>
