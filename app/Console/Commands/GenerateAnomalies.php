<?php

namespace App\Console\Commands;

use App\DbModels\Article;
use App\DbModels\StatisticViews;
use Illuminate\Console\Command;

class GenerateAnomalies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-anomalies';

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
        $articles = Article::query()->get();

        foreach ($articles as $article) {
            $stats = StatisticViews::query()
                ->where('entity_id', $article->id)
                ->where('period', 'month')
                ->get();

            $randomValue = $stats->random(1)->first();

            $valueToUpdate = $randomValue->value + random_int(200, 300);

            $sum = $stats->sum(fn ($x) => $x->value) + $valueToUpdate;

            StatisticViews::query()
                ->where('id', $randomValue->id)
                ->update([
                    'value' => $valueToUpdate,
                ]);

            StatisticViews::query()
                ->where('entity_id', $article->id)
                ->where('period', 'whole')
                ->update([
                    'value' => $sum,
                ]);
        }
    }
}
