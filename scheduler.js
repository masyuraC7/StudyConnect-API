const { exec } = require('child_process');
const cron = require('node-cron');

// Jalankan setiap menit
cron.schedule('* * * * *', () => {
    console.log('Running Laravel Scheduler...');

    // Jalankan perintah Laravel Scheduler
    exec('php artisan schedule:run', (error, stdout, stderr) => {
        if (error) {
            console.error(`Error: ${error.message}`);
            return;
        }
        if (stderr) {
            console.error(`Stderr: ${stderr}`);
            return;
        }
        console.log(`Output: ${stdout}`);
    });
});

console.log('Scheduler started. Waiting for tasks...');