<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

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
