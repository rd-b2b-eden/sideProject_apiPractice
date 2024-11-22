<?php

namespace App\Console\Commands;

use App\Exceptions\ApiException;
use App\Exceptions\DatabaseException;
use App\Service\DataService;
use Illuminate\Console\Command;

class CreateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:create {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立隨機資料
                              {count : 隨機資料的筆數}';

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
     * @throws DatabaseException
     */
    public function handle(): void
    {
        $count = $this->argument('count');
        if ($count === null) {
            throw new ApiException('[parameter] 輸入參數count錯誤');
        }else{
            $dataService = new DataService();
            $response = $dataService->createData($count);
            $this->info('資料產生成功，共產生' . $count . '筆');
        }
    }
}
