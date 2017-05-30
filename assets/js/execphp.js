var exec = require('child_process').exec;

exec('php core/i2c.php', function (error, stdOut, stdErr) {
    // do what you want!
    simulateIO(true);
});