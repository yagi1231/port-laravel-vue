<?php
declare(strict_types=1);

namespace App\Servises;

use Illuminate\Support\Facades\DB;

class AnalysisServise
{
    public static function perDay($subQuery, $request)
    {
        $query = $subQuery->groupBy('id')->selectRaw('id, SUM(subtotal) as totalPerPurchase, DATE_FORMAT(time, "%Y/%m/%d") as time')->groupBy('time');

        $data = DB::table($query)
            ->groupBy('time')
            ->selectRaw('time, sum(totalPerPurchase) as total, avg(totalPerPurchase) as average, count(time) as count')
            ->orderBy('time')
            ->get();

        if ($request->category === '件数') {
            $totals = $data->pluck('count');
            $title = '件数';
        } elseif ($request->category === '平均') {
            $totals = $data->pluck('average');
            $title = '平均';
        } else {
            $totals = $data->pluck('total');
            $title = '合計';
        }

        $labels = $data->pluck('time');

        return [$data, $labels, $totals, $title];
    }

    public static function perMonth($subQuery, $request)
    {
        $query = $subQuery->groupBy('id')->selectRaw('id, SUM(subtotal) as totalPerPurchase, DATE_FORMAT(time, "%Y/%m") as time')->groupBy('time');
        $data = DB::table($query)
            ->groupBy('time')
            ->orderBy('time')
            ->selectRaw('time, sum(totalPerPurchase) as total, avg(totalPerPurchase) as average, count(time) as count')
            ->get();

        if ($request->category === '件数') {
            $totals = $data->pluck('count');
            $title = '件数';
        } elseif ($request->category === '平均') {
            $totals = $data->pluck('average');
            $title = '平均';
        } else {
            $totals = $data->pluck('total');
            $title = '合計';
        }

        $labels = $data->pluck('time');

        return [$data, $labels, $totals, $title];
    }

    public static function perYear($subQuery, $request)
    {
        $query = $subQuery->groupBy('id')->selectRaw('id, SUM(subtotal) as totalPerPurchase, DATE_FORMAT(time, "%Y") as time')->groupBy('time');
        $data = DB::table($query)
            ->groupBy('time')
            ->orderBy('time')
            ->selectRaw('time, sum(totalPerPurchase) as total, avg(totalPerPurchase) as average, count(time) as count')
            ->get();

        if ($request->category === '件数') {
            $totals = $data->pluck('count');
            $title = '件数';
        } elseif ($request->category === '平均') {
            $totals = $data->pluck('average');
            $title = '平均';
        } else {
            $totals = $data->pluck('total');
            $title = '合計';
        }

        $labels = $data->pluck('time');

        return [$data, $labels, $totals, $title];
    }

    // public function sort($data, $request) 
    // {
    //     $data->when(!empty($request->category) && !empty($request->sort === '昇順'), function ($q) use ($request) {
    //         switch ($request->category) {
    //             case '日付':
    //                 $q->orderBy('time', 'asc');
    //                 break;
    //             case '合計':
    //                 $q->orderBy('total', 'asc');
    //                 break;
    //             case '平均':
    //                 $q->orderBy('average', 'asc');
    //                 break;
    //             case '件数':
    //                 $q->orderBy('count', 'asc');
    //                 break;
    //         }
    //     })
    //     ->when(!empty($request->category) && !empty($request->sort === '降順'), function ($q) use ($request) {
    //         switch ($request->category) {
    //             case '日付':
    //                 $q->orderBy('time', 'desc');
    //                 break;
    //             case '合計':
    //                 $q->orderBy('total', 'desc');
    //                 break;
    //             case '平均':
    //                 $q->orderBy('average', 'desc');
    //                 break;
    //             case '件数':
    //                 $q->orderBy('count', 'desc');
    //                 break;
    //         }
    //     });
    //     return $data;
    // }
}
