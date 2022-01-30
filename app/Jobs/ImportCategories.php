<?php

namespace App\Jobs;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportCategories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
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
                'picture' => $data[3],
                'created_at' =>$now,
                'updated_at' =>$now,
            ];
        }
        
        Category::upsert($upsert, 'id', ['name','description','picture','created_at','updated_at']);
    }

    
}

