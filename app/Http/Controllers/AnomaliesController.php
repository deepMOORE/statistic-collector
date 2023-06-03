<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DbModels\Article;
use App\DbModels\StatisticViews;
use App\Models\ArticleStatisticModel;
use Carbon\Carbon;

class AnomaliesController
{
    public function index(int $articleId)
    {
        $stats = StatisticViews::query()
            ->where('entity_id', $articleId)
            ->where('period', 'month')
            ->orderBy('period_date')
            ->select([
                'period_date',
                'value',
            ])
            ->get();

        $article = Article::query()->firstWhere('id', $articleId);

        $model = new ArticleStatisticModel();
        $model->articleId = $article->id;
        $model->title = $article->title;
        $model->maxValue = $stats->max(fn ($x) => $x->value);
        $model->minValue = $stats->max(fn ($x) => $x->value);
        $model->datesStr = base64_encode(implode(', ', $stats
            ->pluck('period_date')
            ->map(fn (Carbon $period) => $period->format('Y-m-d'))
            ->all()
        ));
        $model->valuesStr = base64_encode(implode(', ', $stats
            ->pluck('value')
            ->all()
        ));

        return view('anomalies.welcome', ['model' => $model]);
    }
}
