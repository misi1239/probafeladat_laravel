<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function projectTracks(): HasMany
    {
        return $this->hasMany(ProjectTracks::class);
    }
}
