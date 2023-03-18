<?php

namespace App\Http\Controllers\Web;

use App\Actions\Code\CreateCodeAction;
use App\Actions\Code\UpdateCodeAction;
use App\Actions\Project\ToggleAdminStatusAction;
use App\Actions\Project\ToggleProjectMembershipAction;
use App\Actions\User\GetAllUsersAction;
use App\Data\Code\StoreCodeData;
use App\Data\Code\UpdateCodeData;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Code;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProjectSettingsController extends Controller
{
    /**
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function index(Project $project)
    {
        $this->authorize('manage', $project);

        return Inertia::render('Project/Settings', [
            'project' => new ProjectResource($project->load('members', 'codes')),
            'users' => UserResource::collection(GetAllUsersAction::run(['perPage' => 10000])),
        ]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function store(StoreCodeData $data, Project $project)
    {
        $this->authorize('manage', $project);

        CreateCodeAction::run($data, $project);

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function update(UpdateCodeData $data, Project $project, Code $code)
    {
        $this->authorize('manage', $project);

        UpdateCodeAction::run($data, $code);

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Project $project, Code $code)
    {
        $this->authorize('manage', $project);

        $code->delete();

        return Redirect::back();
    }

    /**
     * @return mixed
     *
     * @throws AuthorizationException
     */
    public function toggleRole(Project $project, User $member)
    {
        $this->authorize('manage', $project);

        ToggleAdminStatusAction::run($project, $member);

        return Redirect::back()->success('Project admin status updated.');
    }

    /**
     * @return mixed
     *
     * @throws AuthorizationException
     */
    public function toggleMembership(Project $project, User $member)
    {
        $this->authorize('manage', $project);

        $status = $project->hasUser($member);

        $message = $status ? 'User removed from project' : 'User added to project';

        ToggleProjectMembershipAction::run($project, $member);

        return Redirect()->back()->success($message);
    }
}
