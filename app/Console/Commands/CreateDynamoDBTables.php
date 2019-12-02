<?php

namespace App\Console\Commands;

use BaoPham\DynamoDb\DynamoDbClientService;
use Illuminate\Console\Command;
use Monolog\Handler\DynamoDbHandler;

class CreateDynamoDBTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamodb:create-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create DynamoDB tables';

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
            $table = $dynamodb->createTable($tableSchema);

            $count++;
        }

        $this->info(sprintf('Created %d table(s)', $count));
    }
}
