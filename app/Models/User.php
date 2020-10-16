<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $collection = 'users';
    protected $primaryKey = '_id';

    // protected $connection = 'laravelMongo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function withDepartment(string $id)
    {
        $this->department()->associate(Department::find($id));

        return $this;
    }

    public function writings()
    {
        return $this->belongsToMany(Writing::class, 'group_ids', 'user_ids');
    }

    public static function withRelations(User $user = null)
    {
        if ($user != null) {
            $department = Department::find($user->department_id);
            $user->department = $department;
            return $user;
        }

        $users = User::all();

        foreach ($users as $user) {
            $department = Department::find($user->department_id);
            $user->department = $department;
        }
        return $users;
    }
}
