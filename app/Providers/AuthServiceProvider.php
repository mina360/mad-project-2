<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\ExamStudent;
use App\Policies\ExamStudentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        ExamStudent::class => ExamStudentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isStudent', function (User $user) {
            return ($user->role === 'student');
        });
        Gate::define('isExamStudentOwner', function (User $user, ExamStudent $exam_student) {
            return ($user->id === $exam_student->student_id);
        });
    }
}
