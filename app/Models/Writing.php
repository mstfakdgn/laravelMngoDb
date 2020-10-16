<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;


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

    public static function withRelationships(Writing $writing = null)
    {
        if ($writing == null) {
            $writings = Writing::all();
    
            foreach ($writings as $writing) {
                $users = [];
                foreach ($writing->user_ids as $userId) {
                    $user = User::find($userId);
                    array_push($users, $user);
                }
                $writing->users = $users;
            }
    
            return $writings;
        }
        $users = [];
        foreach ($writing->user_ids as $userId) {
            $user = User::find($userId);
            array_push($users, $user);
        }
        $writing->users = $users;

        return $writing;

    }
}
