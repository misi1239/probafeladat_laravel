<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find(int $id)
 */
class ProjectDetails extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'start', 'finish', 'note', 'isStarted', 'isStopped', 'isCompleted'];

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }
}
