<?php

namespace App\Models\Native;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $collection = 'departments';
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

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
