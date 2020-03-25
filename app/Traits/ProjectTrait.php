<?php
namespace App\Traits;

use App\Project;
use App\Skill;
use Illuminate\Support\Facades\DB;

trait ProjectTrait
{

    protected $pathProject = 'upload/project/';

    public function rules($request)
    {
        return [
            'title' => 'required',
            'description' => 'required|max:2000',
            'start' => $request->start ? 'date_format:Y-m-d H:m:s' : '',
            'end' => $request->end ? 'date_format:Y-m-d H:m:s|after_or_equal:start' : '',
            'type' => 'required',
            'skills' => 'required',
            'attachments.*' => $request->attachments ? 'mimes:jpg,png,doc,docx,pdf|max:20000' : '',
        ];
    }

    public function getAllProjects($request, $userID = null)
    {
        $projects = Project::query();

        if ($userID) $projects->where('user_id', $userID);

        if (isset($request['filter'])) {
            $projects->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', "%{$request['filter']}%")
                    ->orWhere('organization', 'LIKE', "%{$request['filter']}%")
                    ->orWhere('type', 'LIKE', "%{$request['filter']}%");
            });
        }

        if ($request['name'] == 'user') $projects->join('users', 'users.id', '=', 'projects.user_id')
            ->orderBy('users.name', $request['sort']);
        else $projects->orderBy($request['name'], $request['sort']);

        return $projects->paginate(5)->appends($request);
    }

    public function storeProject($request, $user)
    {
        $this->validate($request, $this->rules($request));

        DB::transaction(function () use ($request, $user) {

            $project = Project::create([
                'user_id' => $user,
                'title' => $request->title,
                'description' => $request->description,
                'organization' => $request->organization,
                'start' => $request->start,
                'end' => $request->end,
                'type' => $request->type
            ]);

            $project->skill()->save(new Skill([
                'skills' => json_encode(explode(PHP_EOL, $request->skills))
            ]));

            if ($request->attachments) {

                $path = $this->pathProject . $project->id . '/';
                mkdir($path, 0777, true);

                $attachments = [];
                foreach ($request->attachments as $item) {
                    $name = rand(111111, 999999) . '.' . $item->getClientOriginalExtension();
                    $item->move($path, $name);
                    $data['name'] = $name;
                    $data['original'] = $item->getClientOriginalName();
                    $data['extension'] = $item->getClientOriginalExtension();
                    $data['path'] = $path . $name;
                    $attachments[] = $data;
                }

                $project->update([
                    'attachments' => json_encode($attachments)
                ]);

            }

        });

    }

    public function projectUpdate($request, $projectID, $userID)
    {
        $this->validate($request, $this->rules($request));

        DB::transaction(function () use ($request, $projectID) {

            $project = Project::find($projectID);

            $project->update([
                'title' => $request->title,
                'description' => $request->description,
                'organization' => $request->organization,
                'start' => $request->start,
                'end' => $request->end,
                'type' => $request->type
            ]);

            $project->skill()->update([
                'skills' => json_encode(explode(PHP_EOL, $request->skills))
            ]);

            if ($request->attachments) {

                $path = $this->pathProject . $project->id . '/';

                if ($project->getAttachments()) {
                    foreach ($project->getAttachments() as $item) @unlink($path . $item->name);
                }

                $attachments = [];
                foreach ($request->attachments as $item) {
                    $name = rand(111111, 999999) . '.' . $item->getClientOriginalExtension();
                    $item->move($path, $name);
                    $data['name'] = $name;
                    $data['original'] = $item->getClientOriginalName();
                    $data['extension'] = $item->getClientOriginalExtension();
                    $data['path'] = $path . $name;
                    $attachments[] = $data;
                }

                $project->update([
                    'attachments' => json_encode($attachments)
                ]);

            }

        });
    }

    public function deleteProject($project)
    {
        if ($project->getAttachments()) {
            foreach ($project->getAttachments() as $item) {
                @unlink($item->path);
            }
            @rmdir($this->pathProject . '/' . $project->id);
        }

        $project->delete();
    }

    public function removeAllProjects()
    {
        $projects = Project::all();

        foreach ($projects as $project) $this->deleteProject($project);
    }

}