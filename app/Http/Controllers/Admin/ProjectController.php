<?php
namespace App\Http\Controllers\Admin;

use App\Excel\ExampleExcel;
use App\Excel\ImportExcel;
use App\Http\Controllers\Controller;
use App\Project;
use App\Traits\ProjectTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    use ProjectTrait;

    public function index(Request $request)
    {
        $data = $request->all();

        if (!$request->name) $data['name'] = 'title';
        if (!$request->sort) $data['sort'] = 'asc';

        $projects = $this->getAllProjects($data);

        if ($request->ajax()) {

            $html = view('admin.project.include.ajax-loader', compact('projects', 'data'))->render();

            return response()->json(['status' => 'ok', 'innerHtml' => $html]);
        }

        return view('admin.project.index', compact('projects', 'data'));
    }

    public function edit($id)
    {
        $project = Project::with(['skill', 'user'])->find($id);

        if ($project) return view('admin.project.edit', compact('project'));

        return redirect()->route('admin.project.index')->with('alert', 'Project Not Found');
    }

    public function create()
    {
        return view('admin.project.create');
    }

    public function store(Request $request)
    {
        $this->storeProject($request, $request->user);

        return redirect()->route('admin.project.index')->with('alert', 'Project Create');
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) return redirect()->route('adnib.project.edit', $id);

        $this->projectUpdate($request, $id, $request->user);

        return redirect()->route('admin.project.index')->with('alert', 'Project Update');
    }

    public function show($id)
    {
        $project = Project::with(['skill', 'user'])->find($id);

        if (!$project) return redirect()->route('admin.project.index')->with('alert', 'Project Not Found');

        return view('admin.project.show', compact('project'));
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) return redirect()->route('admin.project.index')->with('alert', 'Project Not Found');

        $this->deleteProject($project);

        return redirect()->route('admin.project.index')->with('alert', 'Project Delete');
    }

    public function deleteAllProjects()
    {
        $this->removeAllProjects();

        return redirect()->route('admin.project.index')->with('alert', 'All Projects Delete');
    }

    public function downloadExample()
    {
        return Excel::download(new ExampleExcel(), 'example.xlsx');
    }

    public function importExcel(Request $request)
    {
        $this->validate($request, [
            'customFile' => 'required|mimes:xlsx,xls,csv,txt|max:20000'
        ]);

        Excel::import(new ImportExcel(), $request->customFile);

        return redirect()->route('admin.project.index')->with('alert', 'Import Done');
    }
}