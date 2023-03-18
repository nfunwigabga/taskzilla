<?php

namespace App\Models;

use App\Enums\Roles;
use App\Traits\HasAvatar;
use App\Traits\HasStringPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        SoftDeletes,
        HasStringPrimaryKey,
        HasAvatar,
        Searchable,
        CausesActivity;

    protected string $keyPrefix = 'usr';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $fillable = [
        'first_name',
        'last_name',
        'job_title',
        'about',
        'is_active',
        'role',
        'should_be_logged_out',
        'email',
        'password',
        'avatar_disk',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'should_be_logged_out' => 'boolean',
        'email_verified_at' => 'datetime',
        'projects.pivot.is_favorite' => 'boolean',
        'projects.pivot.is_admin' => 'boolean',
        'role' => Roles::class,
    ];

    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_members')
            ->withPivot(['is_admin', 'is_favorite'])
            ->withTimestamps();
    }

    public function hasFavedProject(Project $project)
    {
        if (!$project->hasUser($this)) {
            return false;
        }

        return (bool)$this->projects()->where('id', $project->id)
            ->first()?->pivot->is_favorite;
    }

    public function isProjectOwner(Project $project)
    {
        return $project->user_id == $this->id;
    }

    public function isProjectAdmin(Project $project)
    {
        if (!$project->hasUser($this)) {
            return false;
        }

        return $this->projects()->whereId($project->id)->first()?->pivot->is_admin;
    }

    public function isProjectAdminOrOwner(Project $project)
    {
        return $this->isProjectOwner($project) || $this->isProjectAdmin($project);
    }

    public function isGuestOnProject($project)
    {
        return $this->projects->contains($project) &&
            $this->ownedProjects->doesntContain($project);
    }

    public function isAdminOrSuperAdmin()
    {
        return $this->role == Roles::SUPER_ADMIN || $this->role == Roles::ADMIN;
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusAttribute()
    {
        return $this->is_active ? 'Active' : 'Disabled';
    }

    #[SearchUsingPrefix(['first_name', 'last_name', 'email'])]
    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email
        ];
    }
}
