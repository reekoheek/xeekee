<?php
use Michelf\MarkdownExtra as Markdown;
?>
<style>
    pre {
        padding: 10px;
        margin: 0;
        background-color: #ddd;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo URL::base('/vendor/prettify/prettify.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo URL::base('/vendor/prettify/prettify.clean.css') ?>">

<div id="markdown-content">
<?php if($entry->isWorkspace()): ?>
    <h1><?php echo $entry->getWorkspace()->get('title'); ?></h1>
<?php endif; ?>
<?php //echo Markdown::defaultTransform(@$entry['body']) ?>
<?php echo $entry->renderContent(); ?>
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

<script type="text/javascript" src="<?php echo URL::base('/vendor/prettify/prettify.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::base('/vendor/jquery/jquery-1.11.1.min.js') ?>"></script>
<script type="text/javascript">
    prettyPrint();

    $('#markdown-content table').addClass('table table-striped table-bordered table-hover table-condensed').wrap('<div class="table-responsive"></div>');
</script>