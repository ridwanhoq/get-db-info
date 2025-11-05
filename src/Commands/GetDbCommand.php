<?php

namespace GetDbInfo\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GetDbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get db columns';

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
     * @return int
     */
    public function handle()
    {
        // return 0;


        $action = $this->ask("Choose action from list: \n 
            1: SHOW COLUMN NAMES
            2: SHOW COLUMNS WITH DETAILS
            3: SHOW INDEXES
            4: SHOW SPECIFIC NUMBER OF RECORDS
            5: SHOW TABLES
            6: TABLE DATA
            7: TRUNCATE ALL TELESCOPE ENTRIES
            q: QUIT
        ");

        switch ($action):
            case 1:
                $table = $this->ask("Table Name ?");
                print_r(Schema::getColumnListing($table));
                break;
            case 2:
                break;
            case 3:
                $table = $this->ask("Table Name ?");
                $tableIndexes = DB::select("SHOW INDEX FROM {$table}");
                print_r(array_column($tableIndexes, 'Key_name'));
                break;
            case 4:
                $table = $this->ask("Table Name ?", 'subjects');
                $skip = $this->ask("Skip rows ?", 0);
                $take = $this->ask("Take rows ?", 10);

                $limit = $take - $skip;

                if ($limit > 10) {
                    $this->warning('Maximum 10 rows allowed');
                }

                $allColumns = Schema::getColumnListing($table);

                $columns = $this->ask("Columns ?", implode(',', $allColumns));
                $columns = explode(',', $columns);

                $orderColumn = $this->ask('Order column ?', 'id');
                $orderDirection = $this->ask('Order direction', 'desc');

                $data = DB::table($table)
                    ->select($columns)
                    ->skip($skip)
                    ->take($take)
                    ->orderBy($orderColumn, $orderDirection)
                    ->get();


                print_r($data);
                break;
            case 5:
                $tables = DB::select('SHOW TABLES');
                print_r(array_map('current', $tables));
                break;
            case 6:
                $tableName = $this->ask("Table Name ?");
                $id = $this->ask("ID (optional) ?");
                $data = DB::table($tableName)->where('id', $id)->select('*')->first();
                break;
            case 7:
                $truncateStatement = "
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE TABLE `telescope_entries`;
    TRUNCATE TABLE `telescope_monitoring`;
    TRUNCATE TABLE `telescope_entries_tags`;
    SET FOREIGN_KEY_CHECKS = 1;
";

                DB::unprepared($truncateStatement);
                $this->info('All telescope entries are deleted');
                break;
            case 'q':
                exit;
            default:
                echo 'Wrong choice';
                break;
        endswitch;


        return 0;


    }
}
