<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DbModels\Article;
use App\DbModels\StatisticViews;
use App\Models\ArticleStatisticModel;
use App\Services\AnomalyDetector;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnomaliesController
{
    public function __construct(
        private readonly AnomalyDetector $anomalyDetector,
    ) {
    }

    public function index(int $articleId)
    {
        $stats = $this->getStats($articleId);

        $anomalies = $this->anomalyDetector->detect($stats);

        $article = Article::query()->firstWhere('id', $articleId);

        $model = new ArticleStatisticModel();
        $model->articleId = $article->id;
        $model->title = $article->title;
        $model->datesStr = base64_encode(implode(', ', $stats
            ->pluck('period_date')
            ->map(fn (Carbon $period) => $period->format('Y-m-d'))
            ->all()
        ));
        $model->valuesStr = base64_encode(implode(', ', $stats
            ->pluck('value')
            ->all()
        ));
        $model->anomalyIndexes = base64_encode(implode(', ', $anomalies));

        return view('anomalies.welcome', ['model' => $model]);
    }

    public function download(int $articleId)
    {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment',
            'Expires'             => '0',
            'Pragma'              => 'public',
        ];

        $stats = $this->getStats($articleId)
            ->toArray();

        $stats = array_map(function ($x) {
            $x['period_date'] = Carbon::parse($x['period_date'])->format('Y-m-d');

            return $x;
        }, $stats);

        array_unshift($stats, array_keys($stats[0]));

        $callback = function() use ($stats)
        {
            $FH = fopen('php://output', 'w');
            foreach ($stats as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        $name = 'views_' . Carbon::now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload($callback, $name, $headers);
    }

    private function getStats(int $articleId): Collection
    {
        return StatisticViews::query()
            ->where('entity_id', $articleId)
            ->where('period', 'month')
            ->orderBy('period_date')
            ->select([
                'period_date',
                'value',
            ])
            ->get();
    }
}
