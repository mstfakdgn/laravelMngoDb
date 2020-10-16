<?php

namespace App\Models\Native;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $collection = 'users';
    protected $primaryKey = '_id';

    // protected $connection = 'mongophp';

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
}
