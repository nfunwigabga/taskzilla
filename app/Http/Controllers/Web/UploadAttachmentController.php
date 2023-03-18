<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Task;
use App\Models\Media;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Redirect;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UploadAttachmentController extends Controller
{
    /**
     * @return MediaResource
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function upload(Request $request, Project $project, Task $task)
    {
        $file = $request->file('file');

        $media = $task->addMedia($file)->toMediaCollection('attachments');

        activity()
            ->performedOn($task)
            ->withProperties(['file' => $media->file_name])
            ->event('uploaded')
            ->log('uploaded');

        return new MediaResource($media);
    }

    /**
     * @return BinaryFileResponse
     */
    public function download(Project $project, Task $task, Media $media)
    {
        return response()->download($media->getPath(), $media->file_name);
    }

    /**
     * @return RedirectResponse
     */
    public function destroy(Project $project, Task $task, Media $media)
    {

        activity()
            ->performedOn($task)
            ->withProperties(['file' => $media->file_name])
            ->event('deleted')
            ->log('deleted');

        $media->delete();
        
        return Redirect::back();
    }
}
