<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static find($id)
 */
class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function projectDetails(): HasMany
    {
        return $this->hasMany(ProjectDetails::class, 'project_id');
    }
}
