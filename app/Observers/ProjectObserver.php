<?php

namespace App\Observers;

use App\Models\Project;
use App\Support\CodeSeedData;

class ProjectObserver
{
    public function created(Project $project)
    {
        foreach (CodeSeedData::SECTION_SEED as $code) {
            $project->codes()->create($code);
        }

        foreach (CodeSeedData::TYPE_SEED as $code) {
            $project->codes()->create($code);
        }

        foreach (CodeSeedData::PRIORITY_SEED as $code) {
            $project->codes()->create($code);
        }
    }
}
