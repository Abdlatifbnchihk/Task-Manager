<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();
        $categories = Category::all();
        $statuses = ['todo', 'in_progress', 'completed'];

        foreach ($users as $user) {
            for ($i = 0; $i < 6; $i++) {
                Task::create([
                    'user_id' => $user->id,
                    'category_id' => $categories->random()->id,
                    'title' => "Task $i for {$user->name}",
                    'description' => "Sample description for task $i",
                    'status' => $statuses[array_rand($statuses)],
                ]);
            };
        }
    }
}
