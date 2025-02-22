<?php

namespace App\Providers;

use App\Models\TaskList;
use App\Policies\TaskListPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected array $policies = [
        TaskList::class => TaskListPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
