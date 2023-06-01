<?php declare(strict_types=1);

namespace App\DbModels;

use Database\Factories\TagFactory;

class Tag extends BaseModel
{
    protected static function newFactory()
    {
        return TagFactory::new();
    }

    public function article()
    {
        return $this->hasMany(ArticleTag::class, 'tag_id');
    }
}
