<link rel="stylesheet" type="text/css" href="<?php echo URL::base('/vendor/prettify/prettify.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo URL::base('/vendor/prettify/prettify.clean.css') ?>">
<style type="text/css">
    #preview {
        overflow-y: scroll;
    }

    pre {
        word-wrap: normal;
    }

    pre code {
        white-space: pre;
    }

    body.full-screen {
        padding-top: 0;
    }

    body.full-screen .sidebar {
        display: none;
    }

    body.full-screen .navbar {
        display: none;
    }

    body.full-screen .main {
        padding: 0;
    }

    body.full-screen #button-container {
        display: none;
    }

    body.full-screen #preview {
        margin: 0;
    }

    #fullscreen-target {
        margin-bottom: 0;
    }

    .editor-wrapper {
        padding: 0;
    }
</style>

<form method="post">
    <div class="form-group" id="fullscreen-target">
        <div class="row">
            <div class="col-md-6 col-sm-6 editor-wrapper">
                <textarea name="body" id="editor" data-editor="markdown" rows="32"><?php echo @$entry['body'] ?></textarea>
            </div>
            <div class="col-md-6 col-sm-6 well" id="preview">
            </div>
        </div>
    </div>

    <p id="button-container">
        <input type="submit" value="Save" class="btn btn-default">
        <!-- <a href="<?php echo \URL::current() ?>" class="btn btn-default">Show</a> -->
        <?php if ($entry->isWorkspace()): ?>
            <a href="<?php echo \URL::site('/admin/workspace/'.$entry->getWorkspace()->getId().'/update') ?>" class="btn btn-default">Update Workspace</a>
        <?php else: ?>
            <a href="<?php echo \URL::site('/admin/workspace/null/create').'?path='.$app->request->getPathInfo() ?>" class="btn btn-default">Create Workspace</a>
        <?php endif ?>
        <button class="btn btn-default" id="full-screen">Toggle Full Screen</button>
    </p>
</form>

<script type="text/javascript" src="<?php echo URL::base('/vendor/jquery/jquery-1.11.1.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::base('/vendor/prettify/prettify.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::base('/vendor/marked/marked.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::base('/vendor/ace/ace.js') ?>"></script>
<script type="text/javascript" src="<?php echo URL::base('/vendor/screenfull/screenfull.min.js') ?>"></script>

<script type="text/javascript">
    // Close alert
    $(".alert").hide();

    // Enable syntax highlighting on marked js
    marked.setOptions({
        highlight: function (code, lang) {
            // Fix for HTML code block
            if (lang === 'html') {
                code = $('<div />').text(code).html();
            }

            return prettyPrintOne(code, lang, false);
        },
        gfm: true,
        tables: true
    });

    // Some variable and instantiating ace-js
    var textarea = $("#editor"),
        editDiv = $('<div>', {
            position: 'absolute',
            width: '100%',
            height: textarea.height(),
            'class': textarea.attr('class')
        }).insertBefore(textarea),
        editor = window.editor = ace.edit(editDiv[0]);

    // hide textarea
    textarea.css('display', 'none');

    // Keybind for editor, updating the input :)
    $(document).on('keyup', '.ace_text-input', function (e) {
        var html = marked(editor.getSession().getValue());

        updatePreview(html);
    });

    // submit handling
    textarea.closest('form').submit(function () {
        textarea.val(editor.getSession().getValue());
    });

    editor.renderer.setShowGutter(true); // show line number
    editor.getSession().setValue(textarea.val()); // set value based on our textarea
    editor.getSession().setMode('ace/mode/markdown'); //mode
    editor.setTheme('ace/theme/monokai'); // theme
    editor.setShowPrintMargin(false); // disable margin

    $('#preview').height($('.ace_editor').height() - 40);
    
    editor.focus(); //To focus the ace editor
    var n = editor.getSession().getValue().split("\n").length; // To count total no. of lines
    editor.gotoLine(n); //Go to end of document

    updatePreview(marked(editor.getSession().getValue()));

    // Detect full screen
    if (screenfull.enabled) {
        document.addEventListener(screenfull.raw.fullscreenchange, function () {
            if (screenfull.isFullscreen) {
                $('body').addClass('full-screen');
                $('.main').attr('class', 'col-sm-12 col-md-12 main');
                $('.ace_editor').height($(document).height());
                $('#preview').height($('.ace_editor').height() - 40);
                $(".alert").show();
            } else {
                $(".alert").hide();
                $('body').removeClass('full-screen');
                $('.ace_editor').height(640);
                $('.main').attr('class', "col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main");
                $('#preview').height($('.ace_editor').height() - 40);
            }
        });
    }

    // Button for toggle full-screen mode
    $('#full-screen').click(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        if (screenfull.enabled) {
            $('body').addClass('full-screen');
            screenfull.request();
        } else {
            alert('Your browser doesn\'t support full screen mode');
        }
    });

    // Update preview
    function updatePreview(html)
    {
        if (! html) {
            html = '<p>Nothing to preview</p>';
        }

        $('#preview').html(html);

        // Optional to give some styling
        $('#preview table').addClass('table table-striped table-bordered table-hover table-condensed');

        // Make our table become responsive
        if (! $('#preview table').closest('div').hasClass('table-responsive')) {
            $('#preview table').wrap('<div class="table-responsive"></div>');
        }

        $('#preview pre').addClass('prettyprint pre-scrollable');

        prettyPrint();
    }
</script>