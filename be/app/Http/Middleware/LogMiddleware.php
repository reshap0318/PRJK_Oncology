<?php

namespace App\Http\Middleware;

use App\Models\System\LogUserModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class LogMiddleware
{
    public function handle(Request $request, Closure $next, string $tag): Response
    {
        $response = $next($request);
        $path = $request->path();

        // except list
        // if(Str::contains($path, ["table", "result"])) return $response;

        try {
            $datas = $request->except(['password', 'confirm_password']);
            $method = Str::lower($request->method());

            $action = 'mengakses detail halaman';
            $payload = [];
            if ($request->isMethod('post')) {
                $action = 'menambahkan data';
            } else if (in_array($method, ['patch', 'put'])) {
                $action = 'mengubah data';
            } else if ($request->isMethod('delete')) {
                $action = 'menghapus data';
            }

            $payload = json_decode($response->getContent(), true, 512);

            //get only file name
            foreach ($datas as $key => $value) {
                if ($request->hasFile($key)) {
                    $datas[$key] = $value->getClientOriginalName();
                }
            }

            $data = [
                'ip_address'        => $request->ip(),
                'user_id'           => Auth::id(),
                'url'               => $path,
                'method'            => $method,
                'status'            => $response->status(),
                'description'       => $action . " " . $tag,
                'request_payload'   => $datas,
                'response_payload'  => $payload,
                'server_time'       => now()
            ];

            LogUserModel::create($data);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $response;
    }
}
