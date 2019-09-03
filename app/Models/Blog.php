<?php

namespace Rspafs\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Rspafs\Observers\BlogObserver;
use Rspafs\Models\User;

class Blog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'blogs';

    static function uriKey()
    {
        return 'blog';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'desc', 
        'user_id',  
        'is_released',
        'view_amount', 
        'created_at', 
        'updated_at',
        'deleted_at',
        'released_at',
        'last_viewed_at'
    ];

    //append extra attributes to the model
    protected $appends = [
        'createrName'
    ];

    public static function boot()
    {
        parent::boot();

        static::observe(BlogObserver::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return '_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Add a createrName attribute to each blog
    public function getCreaterNameAttribute() 
    {
        $user = User::find($this->user_id); //If a user was deleted, it will happen $user equal to null.
        return empty($user) ? '' : $user->name;
    }
}
