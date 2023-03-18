<?php

namespace App\Actions\Task;

use App\Models\Task;

class UpdateDraggableTaskAction
{
    public static function run(array $data)
    {
        foreach ($data as $index => $sortable) {
            Task::findOrFail($sortable['task'])->update([
                'section_id' => $sortable['section'],
                'sort_order' => $index + 1,
            ]);
        }
    }
}
