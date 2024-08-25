<?php

namespace App\Jobs;

use App\Models\Products;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class Import_Products implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $list_products;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $list_products)
    {
        $this->list_products = $list_products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $list = Http::withHeaders([
            'accept' => 'application/octet-stream',
        ])->get("https://challenges.coode.sh/food/data/json/{$this->list_products}")->body();

        $path = "/foods/$this->list_products";
        Storage::put($path, $list);

        $file = Storage::path($path);
        $zd = gzopen($file, "r");

        $products = array();
        while (!gzeof($zd)) {
            $products[] = json_decode(gzgets($zd), 1);
            if (count($products) == 100) {
                break;
            }
        }

        $erros = array();
        foreach ($products as $product) {
            try {
                $product_db = Products::where('code', '=', $product['code'])->first();
                if ($product_db !== null) {
                    $product_db->update($product);
                } else {
                    Products::create($product);
                }
            } catch (Exception $e) {
                $erros = ['message' => 'product not imported', 'code' => $product['code'], 'list' => $this->list_products, 'date' => now()->toDateTimeString()];
            }
        }

        Cache::forever('erros_import', $erros);
        Cache::forever('import_products', now()->toDateTimeString());
        Storage::delete($path);
    }
}
