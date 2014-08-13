var moment = require('moment'),
    mustache = require('mustache'),
    fs = require('fs'),
    spawn = require('child_process').spawn;

module.exports = function() {
    "use strict";

    var mkdirp = this.require('mkdirp'),
        Q = this.require('q');

    this.task('init', function(logger) {
        return this.exec(['php', 'composer', 'install'], logger);
    });

    this.task('serve', function(logger) {
        if (!this.argv.t) {
            this.argv.t = './www';
        }
        return this.exec(['php', 'serve'], logger);
    });

    this.task('migrate:generate', function() {
        var logger = arguments[arguments.length - 1],
            className = 'Migrate',
            title = 'Migrate',
            now = new Date();

        for(var i = 0; i < arguments.length - 1; i++) {
            var s = arguments[i].toLowerCase(),
                w = s[0].toUpperCase() + s.substr(1);
            className += w;
            title += ' ' + w;
        }

        className += '_' + moment.utc(now).format('YYYYMMDDHHmmss');

        mkdirp.sync('migrations');

        var content = mustache.render(fs.readFileSync('pax_templates/Migrate.php').toString(), {
            className: className,
            title: title,
            time: moment.utc(now).format()
        });

        fs.writeFile('migrations/' + className + '.php', content);
    });

    this.task('migrate', function() {
        var logger = arguments[arguments.length - 1],
            cmd = spawn('php', ['index.php', 'migrate', 'show'], {
                cwd: 'www'
            }),
            deferred = Q.defer();

        logger.head('Show migration...');

        cmd.stdout.on('data', function(data) {
            logger.log(data.toString().trim());
        });

        cmd.stderr.on('data', function(data) {
            logger.error(data.toString().trim());
        });

        cmd.on('close', function() {
            deferred.resolve();
        });

        return deferred.promise;
    });

    this.task('migrate:run', function() {
        var logger = arguments[arguments.length - 1],
            cmd = spawn('php', ['index.php', 'migrate', 'run'], {
                cwd: 'www'
            }),
            deferred = Q.defer();

        logger.head('Run migration...');

        cmd.stdout.on('data', function(data) {
            logger.log(data.toString().trim());
        });

        cmd.stderr.on('data', function(data) {
            logger.error(data.toString().trim());
        });

        cmd.on('close', function() {
            deferred.resolve();
        });

        return deferred.promise;
    });

    this.task('migrate:rollback', function() {
        var logger = arguments[arguments.length - 1],
            cmd = spawn('php', ['index.php', 'migrate', 'rollback'], {
                cwd: 'www'
            }),
            deferred = Q.defer();

        logger.head('Rollback migration...');

        cmd.stdout.on('data', function(data) {
            logger.log(data.toString().trim());
        });

        cmd.stderr.on('data', function(data) {
            logger.error(data.toString().trim());
        });

        cmd.on('close', function() {
            deferred.resolve();
        });

        return deferred.promise;
    });
};
