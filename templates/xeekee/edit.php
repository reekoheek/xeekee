<h2>Edit</h2>

<style>
    .f > * {
        width: 100%;
    }
</style>

<form method="post" action="">
    <div>
        <label>Body</label>
    </div>
    <div class="f">
        <textarea name="body" rows="20"><?php echo @$entry['body'] ?></textarea>
    </div>

    <div class="command-bar">
        <input type="submit">
        <a href="<?php echo \URL::current() ?>">Show</a>
    </div>
</form>
