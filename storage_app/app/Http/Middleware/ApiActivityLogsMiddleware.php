<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ApiActivityLogs;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ApiActivityLogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
    
    public function terminate(Request $request, JsonResponse|Response|SymfonyResponse|
            StreamedResponse|RedirectResponse|BinaryFileResponse $response)
    {
        $status = null;
        if(method_exists($response,'status') == true){
            $status = $response->status();
        }
        
        $logEntry = new ApiActivityLogs();

        $logEntry->request_start_time = date('Y-m-d H:i:s');
        $logEntry->url = $request->url();
        $logEntry->request_HTTP_method = $request->method();
        
        $request_body = $request->all();
        unset($request_body['password']);
        
        $logEntry->request_body = json_encode($request_body);
        $logEntry->request_header = json_encode($request->header());
        $logEntry->ip = $request->ip();
        $logEntry->status_code = $status;
        $logEntry->response_body = json_encode($response->getContent());
        
        $logEntry->save();
        
        $logData = '{"date" : ' . date('Y-m-d H:i:s') . ','
                . '"URL" : ' . $request->url() . ','
                . '"Method":' . $request->method() . ','
                . '"Request Body" : ' . json_encode($request_body) .','
                . '"Request Header" : ' . json_encode($request->header()) .','
                . '"IP" : ' . $request->ip() . ','
                . '"Status" : ' . $status .','
                . '"Response Body" : ' . $response->getContent() . '}' . PHP_EOL;
        
        \Log::info("API Log: " . $logData);
        
    }
}
