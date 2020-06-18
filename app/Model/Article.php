<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\Events\Saved;
use Hyperf\DbConnection\Model\Model;
use App\Queues\SlugQueuesService;
use Hyperf\Utils\ApplicationContext;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $author
 * @property int $like
 * @property string $slug
 * @property string $tag
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Article extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'author' => 'integer', 'like' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * @param Saved $event
     */
    public function saved(Saved $event)
    {
        $slugQueuesService = ApplicationContext::getContainer()->get(slugQueuesService::class);
        $slugQueuesService->push(['id' => $this->id, 'title' => $this->title], 600);
    }
}
