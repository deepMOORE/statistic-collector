<?php

namespace App\Console\Commands;

use App\DbModels\StatisticViews;
use App\Services\AnomalyDetector;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Rubix\ML\AnomalyDetectors\GaussianMLE;
use Rubix\ML\AnomalyDetectors\IsolationForest;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\CSV;

class Train extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:train';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var AnomalyDetector $detector */
        $detector = App::make(AnomalyDetector::class);
        [$a, $b] = $detector->detect($this->getStats(24));

        $c = 2;
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
