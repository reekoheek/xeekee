<?php
use \Michelf\Markdown;
?>
<style>
    pre {
        padding: 10px;
        margin: 0;
        background-color: #ddd;
    }
</style>

<div>
<?php echo Markdown::defaultTransform(@$entry['body']) ?>
</div>

<hr>

<p>
    <a href="<?php echo \URL::current().'?edit' ?>" class="btn btn-default">Edit</a>
    <?php if ($entry->isWorkspace()): ?>
        <a href="<?php echo \URL::site('/admin/workspace/'.$entry->getWorkspace()->getId().'/update') ?>" class="btn btn-default">Update Workspace</a>
    <?php else: ?>
        <a href="<?php echo \URL::site('/admin/workspace/null/create').'?path='.$app->request->getPathInfo() ?>" class="btn btn-default">Create Workspace</a>
    <?php endif ?>
</p>