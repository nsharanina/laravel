<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
| 
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
Artisan::command('exportProductsByCategory', function(){
    $category_id = request('category_id');
    $products = Product::where('category_id', $category_id)->get()->toArray();
    $file = fopen('exportProducts.csv', 'w');
    $columns = [
        'id',
        'name',
        'description',
        'category_id',
        'picture',
        'price',
        'created_at',
        'updated_at'
    ];
    fputcsv($file, $columns, ';');
    foreach ($products as $product){
        $product['name'] = iconv('utf-8', 'windows-1251//IGNORE', $product['name']);
        $product['description'] = iconv('utf-8', 'windows-1251//IGNORE', $product['description']);
        $product['category_id'] = iconv('utf-8', 'windows-1251//IGNORE', $product['category_id']);
        $product['picture'] = iconv('utf-8', 'windows-1251//IGNORE', $product['picture']);
        $product['price'] = iconv('utf-8', 'windows-1251//IGNORE', $product['price']);
        
        fputcsv($file, $product, ';');
    }
    fclose($file);
    dd($category_id);

});


Artisan::command('importCategoriesFromFile', function () {
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
        
    
   /* $file = fopen('categories.csv', 'r');

    $i = 0;
    $insert = [];
    while ($row = fgetcsv($file, 1000, ';')) {
        if ($i++ == 0) {
            $bom = pack('H*','EFBBBF');
            $row = preg_replace("/^$bom/", '', $row);
            $columns = $row;
            continue;
        }

        $data = array_combine($columns, $row);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insert[] = $data;        
    }*/
});

Artisan::command('parseEkatalog', function () {

    $url = 'https://www.e-katalog.ru/ek-list.php?katalog_=189&search_=rtx+3090';

    $data = file_get_contents($url);

    $dom = new DomDocument();
    @$dom->loadHTML($data);

    $xpath = new DomXPath($dom);
    $totalProductsString = $xpath->query("//span[@class='t-g-q']")[0]->nodeValue ?? false;
    
    preg_match_all('/\d+/', $totalProductsString, $matches);
    $totalProducts = (int) $matches[0][0];

    $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");

    $productsOnOnePage = $divs->length;

    $pages = ceil($totalProducts / $productsOnOnePage);

    $products = [];
    foreach ($divs as $div) {
        $a = $xpath->query("descendant::a[@class='model-short-title no-u']", $div);
        $name = $a[0]->nodeValue;

        $price = 'Нет в наличии';
        $ranges = $xpath->query("descendant::div[@class='model-price-range']", $div);

        if ($ranges->length == 1) {
            foreach ($ranges[0]->childNodes as $child) {
                if ($child->nodeName == 'a') {
                    $price = 'от ' . $child->nodeValue;
                }
            }
        }

        $ranges = $xpath->query("descendant::div[@class='pr31 ib']", $div);
        if ($ranges->length == 1) {
            $price = $ranges[0]->nodeValue;
        }
        $products[] = [
            'name' => $name,
            'price' => $price
        ];
    }

    for ($i = 1; $i < $pages; $i++) {
        $nextUrl = "$url&page_=$i";

        $data = file_get_contents($nextUrl);

        $dom = new DomDocument();
        @$dom->loadHTML($data);
    
        $xpath = new DomXPath($dom);
        $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");

        foreach ($divs as $div) {
            $a = $xpath->query("descendant::a[@class='model-short-title no-u']", $div);
            $name = $a[0]->nodeValue;
    
            $price = 'Нет в наличии';
            $ranges = $xpath->query("descendant::div[@class='model-price-range']", $div);
    
            if ($ranges->length == 1) {
                foreach ($ranges[0]->childNodes as $child) {
                    if ($child->nodeName == 'a') {
                        $price = 'от ' . $child->nodeValue;
                    }
                }
            }
    
            $ranges = $xpath->query("descendant::div[@class='pr31 ib']", $div);
            if ($ranges->length == 1) {
                $price = $ranges[0]->nodeValue;
            }
            $products[] = [
                'name' => $name,
                'price' => $price
            ];
        }
    }

    $file = fopen('videocards.csv', 'w');
    foreach ($products as $product) {
        fputcsv($file, $product, ';');
    }
    fclose($file);
});

Artisan::command('massCategoriesInsert', function () {

    $categories = [
        [
            'name' => 'Видеокарты',
            'description' => 'sadfasfsdf',
            'created_at' => date('Y-m-d H:i:s'),
        ],
        [
            'name' => 'Процессоры',
            'description' => '23в23в32в32в3232',
            'created_at' => date('Y-m-d H:i:s'),
        ],
    ];

    Category::insert($categories);
});

Artisan::command('updateCategory', function () {
    Category::where('id', 2)->update([
        'name' => 'Процессоры'
    ]);
});

Artisan::command('deleteCategory', function () {
    // $category = Category::find(1);
    // $category->delete();
    Category::whereNotNull('id')->delete();
});

Artisan::command('createCategory', function () {
    $category = new Category([
        'name' => 'Видеокарты',
        'description' => 'Ждем rtx 3050'
    ]);

    $category->save();
});

Artisan::command('inspire', function () {

    $user = User::find(2);
    $addresses = $user->addresses->filter(function ($address) {
        return $address->main;
    })->pluck('address');

    $addresses = $user->addresses()->where('main', 1)->get();
    dd($addresses);

    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');