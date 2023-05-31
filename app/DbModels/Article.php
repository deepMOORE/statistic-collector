<?php declare(strict_types=1);

namespace App\DbModels;

use Database\Factories\ArticleFactory;

class Article extends BaseModel
{
    protected static function newFactory()
    {
        return ArticleFactory::new();
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
