<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'status',
    ]; 

    public const STATUSES = [
        'todo' => 'To Do',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
    ];
    // 🔗 Relationship: Task belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relationship: Task belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function nextStatus(): string
    {
        return match ($this->status) {
            'todo' => 'in_progress',
            'in_progress' => 'completed',
            default => 'completed',
        };
    }
}
