<?php declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Rubix\ML\AnomalyDetectors\IsolationForest;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Labeled;

class AnomalyDetector
{
    public function detect(Collection $stats)
    {
        $stats = array_map(function ($x) {
            $x['period_date'] = Carbon::parse($x['period_date'])->format('Y-m-d');

            return $x;
        }, $stats->toArray());

        $dataset = Labeled::build(
            array_column($stats, 'value'),
            array_column($stats, 'period_date'),
        );

        [$predictions, $scores] = $this->isolatedForest($dataset);

        $anomalies = array_filter($predictions, fn($p) => $p === 1);

        return array_keys($anomalies);
    }

    private function isolatedForest(Dataset $dataset)
    {
        $model = new IsolationForest(100, 0.2, 0.05);
        $model->train($dataset);

        return [$model->predict($dataset), $model->score($dataset)];
    }
}
