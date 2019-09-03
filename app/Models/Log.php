<?php

namespace Rspafs\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'desc'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function setDescAttribute($value) {
        $this->attributes['desc'] = ucfirst($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
