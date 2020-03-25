<?php
namespace App\Http\Controllers\User;

use App\Excel\ExampleExcel;
use App\Excel\ImportExcel;
use App\Http\Controllers\Controller;
use App\Traits\ProjectTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    use ProjectTrait;

    public function index(Request $request)
    {
        $data = $request->all();

        if (!$request->name) $data['name'] = 'title';
        if (!$request->sort) $data['sort'] = 'asc';

        $projects = $this->getAllProjects($data, Auth::id());

        if ($request->ajax()) {

            $html = view('user.project.include.ajax-loader', compact('projects', 'data'))->render();

            return response()->json(['status' => 'ok', 'innerHtml' => $html]);
        }

        return view('user.project.index', compact('projects', 'data'));
    }

    public function edit($id)
    {
        $project = Auth::user()->projects()->with(['skill'])->find($id);

        if ($project) return view('user.project.edit', compact('project'));

        return redirect()->route('user.project.index')->with('alert', 'Project Not Found');
    }

    public function create()
    {
        return view('user.project.create');
    }

    public function store(Request $request)
    {
        $this->storeProject($request, Auth::id());

        return redirect()->route('user.project.index')->with('alert', 'Project Create');
    }

    public function update(Request $request, $id)
    {
        $project = Auth::user()->projects()->find($id);

        if (!$project) return redirect()->route('user.project.edit', $id);

        $this->projectUpdate($request, $id);

        return redirect()->route('user.project.index')->with('alert', 'Project Update');
    }

    public function show($id)
    {
        $project = Auth::user()->projects()->with(['skill'])->find($id);

        if (!$project) return redirect()->route('user.project.index')->with('alert', 'Project Not Found');

        return view('user.project.show', compact('project'));
    }

    public function destroy($id)
    {
        $project = Auth::user()->projects()->find($id);

        if (!$project) return redirect()->route('user.project.index')->with('alert', 'Project Not Found');

        $this->deleteProject($project);

        return redirect()->route('user.project.index')->with('alert', 'Project Delete');
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

        return redirect()->route('user.project.index')->with('alert', 'Import Done');
    }

}