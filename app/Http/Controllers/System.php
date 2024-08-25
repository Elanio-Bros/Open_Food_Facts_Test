<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'email|required',
            'password' => 'string|required'
        ]);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'user', 'message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
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
