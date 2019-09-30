<?php

namespace Rspafs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rspafs\Observers\TaskObserver;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'user_id'
    ];
    
    public static function boot()
    {
        parent::boot();
        static::observe(TaskObserver::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
