<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTracks extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'start', 'finish', 'note'];

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Projects::class);
    }
}
