<?php

namespace App\Console\Commands;

use BaoPham\DynamoDb\DynamoDbClientService;
use Illuminate\Console\Command;

class DeleteDynamoDBTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamodb:delete-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DynamoDB Delete Tables';

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
     * @param DynamoDbClientService $dynamoService
     */
    public function handle(DynamoDbClientService $dynamoService)
    {
        $dynamodb = $dynamoService->getClient();

        $schema = (require base_path('database/dynamodb/tables.php'));

        $count = 0;

        foreach ($schema as $tableSchema)
        {
            try
            {
                $dynamodb->deleteTable($tableSchema);

                $count++;
            }
            catch (\Exception $ex)
            {
                $this->error($ex->getMessage());
            }
        }

        $this->info(sprintf('Deleted %d table(s)', $count));
    }
}
