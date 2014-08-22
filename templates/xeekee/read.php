<style>
    pre {
        padding: 10px;
        margin: 0;
        background-color: #ddd;
    }
</style>

<div>
<pre><?php echo @$entry['body'] ?></pre>
</div>

<div class="command-bar">
    <a href="<?php echo \URL::current().'?edit' ?>">Edit</a>
    <?php if ($entry->isWorkspace()): ?>
        <a href="<?php echo \URL::site('/admin/workspace/'.$entry->getWorkspace()->getId().'/update') ?>">Update Workspace</a>
    <?php else: ?>
        <a href="<?php echo \URL::site('/admin/workspace/null/create').'?path='.$app->request->getPathInfo() ?>">Create Workspace</a>
    <?php endif ?>
</div>