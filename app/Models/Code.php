<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Code extends BaseModel
{
    protected $casts = [
        'available_in_subtask' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
