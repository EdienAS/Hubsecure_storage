<?php

namespace App\Containers\Traffic\Actions;

use DB;
use ByteUnits\Metric;
use App\Abstracts\Action;
use App\Containers\User\Models\User;
use App\Containers\Traffic\Models\Traffic;

/**
 * Class ShowTrafficAction.
 *
 */
class ShowTrafficAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $user = User::where('uuid', $request->uuid)->first();
        
        $traffic = array();
        $traffic['total_storage'] = Metric::megabytes($user->userSettings->storage_limit_mb)->numberOfBytes();
        $traffic['total_uploaded'] = get_total_uploaded_file_size($user->id);
        
        $traffic['total_downloaded'] = get_total_downloaded_file_size($user->id);
        
        
        $traffic['total_uploaded_percent'] = number_format(
                (explode(' ', $traffic['total_uploaded'])[0]*100/
                explode(' ', $traffic['total_storage'])[0]), 2);
        
        $trafficData = Traffic::query();
        
        switch(strtolower($request->duration)){
            case 'year':
                    $trafficDataYear = $trafficData->select(
                                        DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
                                        DB::raw("SUM(upload) as upload"),
                                        DB::raw("SUM(download) as download")
                                    )
                                    ->where('user_id', $user->id)
                                    ->whereRaw("created_at BETWEEN NOW() - INTERVAL $request->limit YEAR AND NOW()")
                                    ->groupBy('year')
                                    ->orderBy('created_at', 'desc');

                    $trafficDataYear = $trafficDataYear->get()->toArray();

//                    foreach($trafficDataYear as $key => $yearData){
//                        $trafficDataYear[$key]['upload'] = sizeFilter($yearData['upload']);
//                        $trafficDataYear[$key]['download'] = sizeFilter($yearData['download']);
//                    }

                    $traffic['year'] = $trafficDataYear;
                break;
            case 'month':
                    $trafficDataMonth = $trafficData->select(
                                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') as year_and_month"),
                                        DB::raw("SUM(upload) as upload"),
                                        DB::raw("SUM(download) as download")
                                    )
                                    ->where('user_id', $user->id)
                                    ->whereRaw("created_at > NOW() - INTERVAL (DAYOFMONTH(NOW()) - 1) DAY - INTERVAL $request->limit MONTH")
                                    ->groupBy('year_and_month')
                                    ->orderBy('created_at', 'desc');

                    $trafficDataMonth = $trafficDataMonth->get()->toArray();

//                    foreach($trafficDataMonth as $key => $monthData){
//                        $trafficDataMonth[$key]['upload'] = sizeFilter($monthData['upload']);
//                        $trafficDataMonth[$key]['download'] = sizeFilter($monthData['download']);
//                    }

                    $traffic['month'] = $trafficDataMonth;
                break;
            case 'day':
                    $trafficDataDay = $trafficData->select(
                                        DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') AS year_and_month_and_day"),
                                        DB::raw("SUM(upload) as upload"),
                                        DB::raw("SUM(download) as download")
                                    )
                                    ->where('user_id', $user->id)
                                    ->whereRaw("created_at BETWEEN NOW() - INTERVAL $request->limit DAY AND NOW()")
                                    ->groupBy('year_and_month_and_day')
                                    ->orderBy('created_at', 'desc');

                    $trafficDataDay = $trafficDataDay->get()->toArray();

//                    foreach($trafficDataDay as $key => $dayData){
//                        $trafficDataDay[$key]['upload'] = sizeFilter($dayData['upload']);
//                        $trafficDataDay[$key]['download'] = sizeFilter($dayData['download']);
//                    }

                    $traffic['day'] = $trafficDataDay;
                break;
            default:
                break;
        }
        
        return $traffic;
    }
    
}
