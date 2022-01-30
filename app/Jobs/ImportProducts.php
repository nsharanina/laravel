<?php

namespace App\Jobs;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $fileName;
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = $this->fileName;
        $path= storage_path('app/public//temp/'.$fileName);
        $path= storage_path('app/public//temp/newcat.csv');
        $file = fopen($path, 'r');
           
            $carbon = new Carbon();
            $now = $carbon->now()->toDateTimeString();
    
            $i = 0;
            $upsert = [];
            while ($data = fgetcsv($file, 1000, ';')) {
                
                if ($i++ == 0) continue;
                $upsert [] = [
                    'id' =>$data[0],
                    'name' => $data[1],
                    'description' => $data[2],
                    'category_id'=>$data[3],
                    'picture' => $data[4],
                    'price'=>$data[5],
                    'created_at' =>$now,
                    'updated_at' =>$now,
                ];
            }
            Product::upsert($upsert, 'id', ['name','description','category_id','picture','price','created_at','updated_at']);
    }
}
