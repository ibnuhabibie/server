<?php

namespace App\Console\Commands;

use App\Repositories\ShareRepository;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteShare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extinguisher:delete-share
                            {id : The ID of the share that needs to be deleted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a share';

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
     * @param ShareRepository $repository
     */
    public function handle(ShareRepository $repository)
    {
        if ($this->confirm('Do you wish to continue?'))
        {
            try
            {
                $share = $repository->find($this->argument('id'));

                $share->delete();

                $this->info('Share deleted successfully!');
            }
            catch (ModelNotFoundException $ex)
            {
                $this->error('The share does not exist! Exiting');
            }
        }
    }
}
