<?php

namespace App\Console\Commands;

use App\Jobs\ImportFileJob;
use App\Model\Medicine;
use Illuminate\Console\Command;

class ImportFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ImportFile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import csv file';

    public $file_path;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file_path = '/home/forge/api.doctor-app.alpha.logidots.com/1mg_2021_06_25.csv';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ImportFileJob::dispatch($this->file_path);
    }
    public function parse()
    {
        $file = fopen($this->file_path, 'r');
        while (!feof($file)) {
            yield fgetcsv($file);
        }
        return;
    }
}
