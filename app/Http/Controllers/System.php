<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class System extends Controller
{
    public function get_info_serve()
    {
        $response = [
            'time_cron' => Cache::get('import_products'),
            'db_connection' => $this->verify_connection_database(),
            'time' => date('Y-m-d H:i:s'),
            'memory' => $this->usage_memory()
        ];

        return response()->json($response, 200);
    }

    private function usage_memory()
    {
        $size = memory_get_usage(true);
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    private function verify_connection_database()
    {
        try {
            DB::connection("mongodb")->getMongoClient()->listDatabases();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
