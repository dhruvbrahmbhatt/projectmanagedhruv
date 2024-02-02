<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'task',
        'developer_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        // return Tasks::doesnthave('history', 'or', function ($query) {
        //     $query->where('status', 'Done');
        // })->latest()->paginate(20);
        return Tasks::latest()->paginate(20);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function history()
    {
        return $this->hasMany(TaskHistory::class);
    }

    public function isAssigned($id)
    {
        return $this->history->contains('tasks_id', $id);
    }

    public function isAssignedTo()
    {
        return $this->history()->latest()->first('user_id')->user_id;
    }

    public function taskStatus($id)
    {
        return $this->history->contains('status', 'Done');
    }
}
