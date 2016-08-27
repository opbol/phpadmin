<?php

namespace App\Console\Commands;

use App\Repositories\Backup\BackupRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Settings;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class MysqlBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'backup:mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a sqldump of your MySQL database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param BackupRepository $backupRepository
     * @return mixed
     */
    public function handle(BackupRepository $backupRepository)
    {
        $dbHost = $this->getOptionOrConfig('host');
        $dbUser = $this->getOptionOrConfig('user', 'username');
        $dbPass = $this->getOptionOrConfig('password');
        $dbName = $this->getOptionOrConfig('database');
        $filename = $this->getOptionOrConfig('out');
        $gzip = $this->getOptionOrConfig('gzip');
        $currentUser = $this->input->getOption('login');

        if ( empty($filename) ) {
            $path = Settings::get('backup_save_path');
            if (empty($path)) {
                $this->error(trans('app.please_setup_backup_save_path'));
                return;
            }
            $filename = realpath($path) . DIRECTORY_SEPARATOR . date('YmdHis') . '.sql';
        }

        if ( empty($currentUser) ) {
            $enableAutoBackup = Settings::get('endable_auto_backup');
            if ( empty($enableAutoBackup) ) {
                $this->error('Auto backup disabled.');
                return;
            }
        }

        // Build the command to be run
        $cmd = sprintf('mysqldump --host=%s --user=%s --password=%s --single-transaction --routines --triggers %s',
            escapeshellarg($dbHost),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName)
        );

        // Handle gzip
        if ($gzip) {
            $filename .= '.gz';
            $cmd      .= sprintf(' | gzip > %s', escapeshellarg($filename));
        } else {
            $cmd      .= sprintf(' > %s', escapeshellarg($filename));
        }

        // save backup
        $backup = $backupRepository->create([
            'name' => basename($filename),
            'file' => $filename,
            'message' => 'Running.',
            'create_by' => $currentUser ?: 0,
        ]);

        // Run the command
        $this->info('Running backup for database `' . $dbName . '`');
        $this->info('Saving to ' . $filename);
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful()) {
            $backupRepository->update($backup->id, [
                'message' => 'Error: ' . $process->getErrorOutput(),
            ]);
            $this->error($process->getErrorOutput());
            return;
        }

        $backupRepository->update($backup->id, [
            'size' => filesize($filename),
            'md5' => md5(file_get_contents($filename)),
            'message' => 'OK.',
        ]);

        $this->info('Done');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['host', null, InputOption::VALUE_OPTIONAL, 'The database host.'],

            ['user', null, InputOption::VALUE_OPTIONAL, 'The database user for login.'],

            ['password', null, InputOption::VALUE_OPTIONAL, 'The database password for login.'],

            ['database', null, InputOption::VALUE_OPTIONAL, 'The database name.'],

            ['out', null, InputOption::VALUE_OPTIONAL, 'The sql file.'],

            ['login', null, InputOption::VALUE_OPTIONAL, 'The current logined user id.'],

            ['gzip', null, InputOption::VALUE_NONE, 'Use gzip compress.'],
        ];
    }

    private function getOptionOrConfig($option, $config=null) {
        $value = $this->input->getOption($option);
        if ($value === null) {
            $value = Config::get('database.connections.mysql.'.($config ?: $option));
        }
        return $value;
    }
}
