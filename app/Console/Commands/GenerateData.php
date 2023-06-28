<?php

namespace App\Console\Commands;

use App\DbModels\Article;
use App\DbModels\StatisticViews;
use App\DbModels\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class GenerateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate';

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
        $this->measureAction('generation', function () {
            $this->internalHandle();
        });
    }

    public function internalHandle(): void
    {
        $this->measureAction('data truncating', function () {
            Article::query()->truncate();
            StatisticViews::query()->truncate();
        });

        $this->measureAction('generate users', function () {
            User::factory(10)->create();
        });

        $this->measureAction('generate articles', function () {
            $users = User::query()->get();

            $toInsert = [];

            foreach ($users as $user) {
                $toInsert = [
                    ...$toInsert,
                    ...Article::factory(10)->make([
                        'title' => fn () => 'u' . $user->id . ' ' . fake()->realText(10),
                        'user_id' => $user->id,
                    ])->toArray()
                ];
            }

            Article::query()->insert($toInsert);
        });

        $this->measureAction('generate views', function () {
            $this->generateViews(Article::query()->get());
        });
    }

    private function generateViews(Collection $articles): void
    {
        $dateNow = Carbon::now();
        $start = Carbon::createFromTimestamp(0);
        $statToInsert = [];
        foreach ($articles as $article) {
            $totalViews = 0;
            foreach (range(23, 0) as $monthNumber) {
                $viewsInMonth = random_int(150, 250);
                $statToInsert[] = StatisticViews::factory()->make([
                    'user_id' => $article->user_id,
                    'value' => $viewsInMonth,
                    'period_date' => $dateNow->clone()->subMonthsNoOverflow($monthNumber)->startOfMonth(),
                    'period' => 'month',
                    'entity_id' => $article->id,
                ])->toArray();
                $totalViews += $viewsInMonth;
            }
            $statToInsert[] = StatisticViews::factory()->make([
                'user_id' => $article->user_id,
                'value' => $totalViews,
                'period_date' => $start,
                'period' => 'whole',
                'entity_id' => $article->id,
            ])->toArray();
        }
        $chunkSize = 100;
        $chunks = array_chunk($statToInsert, $chunkSize);

        foreach ($chunks as $chunk) {
            StatisticViews::query()->insert($chunk);
        }
    }

    private function measureAction(string $actionName, callable $action): void
    {
        $this->info('Starting ' . $actionName);

        $start = microtime(true);

        $action();

        $dur = microtime(true) - $start;

        $this->info('Completed in ' . round($dur, 2));
    }
}
