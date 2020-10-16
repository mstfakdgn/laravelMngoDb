<?php

namespace App\Models\Native;

use Illuminate\Database\Eloquent\Model;

class Writing extends Model
{
    protected $collection = 'writings';
    protected $primaryKey = '_id';

    // protected $connection = 'laravelMongo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    protected $hidden = ['user_ids'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_ids', 'writing_ids');
    }
}
