<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SpysOneFilterSet;
use App\Services\SpysOneParser;

class ParseSpysOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parse-spys-one';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the most expired spys.one filter set';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        echo "Starting...\n";
        $parser = new SpysOneParser();
        echo "Setting up filters...\n";
        $parser->autoSetupFilterSet();
        echo "Parsing data...\n";
        $parser->ParseData();
        echo "Collected {$parser->getParsedRecordsNum()} record(s)...\n";
        echo "Inserting...\n";
        $parser->insertData();
        echo "Updating filter set...\n";
        $parser->finalUpdateFilterSet();
        echo "Done.\n";
    }
}
