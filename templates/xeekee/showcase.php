
<style>
    .search input {
        width: 100%;
        font-size: 20px;
    }

    .workspaces {
        margin-top: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        /*padding: 0 10px;*/
    }
    .workspaces .workspace {
        /*border: 1px solid blue;*/
        background-color: #efefef;
        margin: 10px;
        color: #444;
        border-radius: 4px;
    }

    .workspaces .workspace a {
        display: block;
        padding: 5px 10px;
        color: #444;
    }

    .workspaces .workspace.empty {
        border: none;
        text-align: center;
        font-size: .8em;
        color: #777;
        padding: 10px;
        font-style: italic;
    }

    .workspaces .workspace h3 {
        padding: 0;
        margin: 0;
        display: inline;
    }

    .workspaces .workspace span.path {
        padding: 0;
        margin: 0;
        display: inline;
        font-size: .8em;
        float: right;
        font-style: italic;
        color: #777;
    }
</style>

<p>
<?php if (!empty($_SESSION['user'])): ?>
    <a href="<?php echo \URL::site('/admin/user') ?>" class="btn btn-default">User</a>
    <a href="<?php echo \URL::site('/admin/workspace') ?>" class="btn btn-default">Workspace</a>
    <!-- <a href="<?php echo \URL::site('/logout') ?>" class="btn btn-default">Logout</a> -->
<?php // else: ?>
    <!-- <a href="<?php echo \URL::site('/login') ?>" class="btn btn-default">Login</a> -->
<?php endif ?>
</p>

<div class="search">
    <form action="">
        <input type="text" name="q" placeholder="Search workspace" value="<?php echo @$q ?>" class="form-control">
    </form>
</div>

<div class="workspaces">
    <?php if (count($entries) <= 0): ?>
        <div class="workspace empty">empty</div>
    <?php else: ?>
        <?php foreach($entries as $entry): ?>
            <div class="workspace">
                <a href="<?php echo \URL::site($entry['path']) ?>">
                    <h3><?php echo $entry['title'] ?: '&nbsp;' ?></h3>
                    <span class="path"><?php echo $entry['path'] ?></span>
                </a>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>