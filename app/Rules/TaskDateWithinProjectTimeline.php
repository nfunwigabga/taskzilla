<?php

namespace App\Rules;

use App\Models\Project;
use Illuminate\Contracts\Validation\Rule;

class TaskDateWithinProjectTimeline implements Rule
{
    public string $feedback = '';

    public function __construct(public Project $project)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }

        $project_start = $this->project->start_date;
        $project_end = $this->project->due_date;

        if ($project_start && $project_start > $value) {
            $this->feedback = "Due date is before project start date ({$project_start})";

            return false;
        }

        if ($project_end && $project_end < $value) {
            $this->feedback = "Due date is after project end date ({$project_end})";

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->feedback;
    }
}
