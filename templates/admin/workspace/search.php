<h2><?php echo ROH\Util\Inflector::pluralize(f('controller.name')) ?></h2>

<p>
    <a href="<?php echo f('controller.url', '/null/create') ?>" class="btn btn-primary">Create</a>
</p>

<div class="table-placeholder">

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <?php if (f('app')->controller->schema()): ?>
                <?php foreach(f('app')->controller->schema() as $name => $field): ?>

                    <th><?php echo $field->label(true) ?></th>

                <?php endforeach ?>
                <?php else: ?>
                    <th>Data</th>
                <?php endif ?>

                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

            <?php if (count($entries)): ?>
            <?php foreach($entries as $entry): ?>

            <tr>
                <?php if (f('app')->controller->schema()): ?>
                <?php foreach(f('app')->controller->schema() as $name => $field): ?>

                <td>
                    <a href="<?php echo f('controller.url', '/'.$entry['$id']) ?>">
                    <?php echo $field->format('readonly', $entry[$name]) ?>
                    </a>
                </td>

                <?php endforeach ?>
                <?php else: ?>
                <td><?php echo reset($entry) ?></td>
                <?php endif ?>

                <td>
                    <a href="<?php echo \URL::site('/admin/workspace/'.$entry['$id'].'/members') ?>">Members</a>
                </td>
            </tr>

            <?php endforeach ?>
            <?php else: ?>

            <tr>
                <td colspan="100">no record!</td>
            </tr>

            <?php endif ?>

        </tbody>
    </table>
</div>