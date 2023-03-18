<?php

namespace App\Http\Resources;

use App\Actions\Code\GetProjectCodesAction;
use App\Support\AuthorizationChecker;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'code' => $this->code,
            'icon' => $this->icon,
            'start_date' => $this->start_date?->isoFormat('YYYY-MM-D'),
            'due_date' => $this->due_date?->isoFormat('YYYY-MM-D'),
            'is_archived' => $this->resource->isArchived(),
            'is_faved' => Auth::user()?->hasFavedProject($this->resource),
            $this->mergeWhen($this->resource->relationLoaded('owner'), [
                'owner' => [
                    'id' => $this->owner->id,
                    'name' => $this->owner->name,
                    'avatar' => $this->owner->profile_photo_url,
                ],
            ]),
            'codes' => $this->when($this->resource->relationLoaded('codes'),
                GetProjectCodesAction::run($this->resource)
            ),
            'members' => $this->when($this->resource->relationLoaded('members'),
                $this->members->map(fn($member) => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'avatar' => $member->profile_photo_url,
                    'is_admin' => $member->isProjectAdmin($this->resource),
                    'is_owner' => $member->isProjectOwner($this->resource),
                ])
            ),
            'can' => AuthorizationChecker::getPermissions($this->resource),
            '_links' => [
                'overview' => route('projects.overview', [$this->id]),
                'list' => route('projects.list', [$this->id]),
                'board' => route('projects.board', [$this->id]),
                'settings' => route('projects.settings', [$this->id]),
            ],
        ];
    }
}
