<?php

namespace Database\Seeders;

use App\DbModels\Article;
use App\DbModels\StatisticViews;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Article::query()->forceDelete();
        StatisticViews::query()->forceDelete();

        Article::factory(10)->create();

        $this->generateViews(Article::query()->pluck('id'));
    }

    private function generateViews(Collection $articleIds): void
    {
        $dateNow = Carbon::now();
        $start = Carbon::createFromTimestamp(0);
        $statToInsert = [];
        foreach ($articleIds as $articleId) {
            $totalViews = 0;
            foreach (range(23, 0) as $monthNumber) {
                $viewsInMonth = random_int(150, 250);
                $statToInsert[] = StatisticViews::factory()->make([
                    'value' => $viewsInMonth,
                    'period_date' => $dateNow->clone()->subMonthsNoOverflow($monthNumber)->startOfMonth(),
                    'period' => 'month',
                    'entity_id' => $articleId,
                ])->toArray();
                $totalViews += $viewsInMonth;
            }
            $statToInsert[] = StatisticViews::factory()->make([
                'value' => $totalViews,
                'period_date' => $start,
                'period' => 'whole',
                'entity_id' => $articleId,
            ])->toArray();
        }
        $chunkSize = 100;
        $chunks = array_chunk($statToInsert, $chunkSize);

        foreach ($chunks as $chunk) {
            StatisticViews::query()->insert($chunk);
        }
    }
}
