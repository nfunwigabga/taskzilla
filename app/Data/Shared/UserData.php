<?php

namespace App\Data\Shared;

use App\Enums\Roles;
use Auth;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string  $id,
        public string  $first_name,
        public string  $last_name,
        public string  $email,
        public ?string $name,
        public ?string $about,
        public ?string $job_title,
        public ?bool   $is_admin,
        public ?bool   $is_superadmin,
        public ?string $role,
        public ?string $avatar = null,
//        public ?array $notification = []
    )
    {
        $this->fill();
    }

    protected function fill(): void
    {
        $this->avatar = Auth::user()?->avatar;
        $this->name = Auth::user()?->name;
        $this->is_admin = Auth::user()->role == Roles::ADMIN;
        $this->is_superadmin = Auth::user()->role == Roles::SUPER_ADMIN;
        $this->role = Auth::user()->role->roleName();

//        $this->notification = [
//            'email_when_invited' => setting('email_when_invited', true),
//            'email_when_invited_responded' => setting('email_when_invited_responded', true),
//            'email_when_assigned' => setting('email_when_assigned', true),
//            'email_on_comment_assignee' => setting('email_on_comment_assignee', true),
//            'email_on_comment_reporter' => setting('email_on_comment_reporter', true),
//            'email_on_project_add' => setting('email_on_project_add', true),
//            'email_on_task_resolved' => setting('email_on_task_resolved', true),
//        ];
    }
}
