<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{

    use HasUuids;
    protected $fillable = [
        'user_id',
        'photo',
        'position',
        'salary',
        'status'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
