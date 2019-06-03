<?php

namespace App\Console\Commands\Author;

use Illuminate\Console\Command;
use App\Services\Handlers\Author\Task\CheckExpiredAt;

class CheckTaskExpiredAt extends Command
{
    /**
     * @var CheckExpiredAt
     */
    private $checkExpiredAt;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:task:check-expired-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command checks whether the authors do not have overdue tasks';

    /**
     * Create a new command instance.
     *
     * @param CheckExpiredAt $checkExpiredAt
     * @return void
     */
    public function __construct(CheckExpiredAt $checkExpiredAt)
    {
        parent::__construct();
        $this->checkExpiredAt = $checkExpiredAt;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkExpiredAt->check();
    }
}