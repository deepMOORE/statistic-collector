<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DbModels\StatisticViews;
use App\Http\Response;
use App\Services\AnomalyDetector;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StatisticsController
{
    public function __construct(
        private readonly AnomalyDetector $anomalyDetector,
    )
    {
    }

    public function getMonthlyStats(Request $request): JsonResponse
    {
        $stats = $this->getStats(
            (int)$request->input('articleId'),
            Carbon::parse($request->input('start')),
            Carbon::parse($request->input('end')),
        );

//        $anomalies = $this->anomalyDetector->detect($stats);

        return Response::success($stats);
    }

    public function download(int $articleId)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $stats = $this->getStats($articleId)
            ->toArray();

        $stats = array_map(function ($x) {
            $x['period_date'] = Carbon::parse($x['period_date'])->format('Y-m-d');

            return $x;
        }, $stats);

        array_unshift($stats, array_keys($stats[0]));

        $callback = function () use ($stats) {
            $FH = fopen('php://output', 'w');
            foreach ($stats as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        $name = 'views_' . Carbon::now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload($callback, $name, $headers);
    }

    private function getStats(
        int    $articleId,
        Carbon $start,
        Carbon $end,
    ): Collection {
        return StatisticViews::query()
            ->where('entity_id', $articleId)
            ->where('period', 'month')
            ->where('period_date', '>=', $start)
            ->where('period_date', '<=', $end)
            ->orderBy('period_date')
            ->select([
                'period_date',
                'value',
            ])
            ->get();
    }
}
