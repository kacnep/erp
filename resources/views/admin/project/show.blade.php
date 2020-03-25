@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Project</div>

                    <div class="card-body">

                        <table class="table">
                            <tbody>
                            <tr>
                                <th class="col-sm-4 text-right">User:</th>
                                <td>{{ $project->user->name }}</td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">Title:</th>
                                <td>{{ $project->title }}</td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">Description:</th>
                                <td>{{ $project->description }}</td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">Organization:</th>
                                <td>{{ $project->organization }}</td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">Start:</th>
                                <td>{{ $project->start ? $project->start : '-' }}</td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">End:</th>
                                <td>{{ $project->end ? $project->end : '-' }}</td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">Attachments:</th>
                                <td>
                                    @if($project->getAttachments())
                                        @foreach($project->getAttachments() as $item)
                                            <a href="{{ asset($item->path) }}" download class="btn btn-dark btn-xs text-uppercase">{{ $item->extension }}</a>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">Type:</th>
                                <td>
                                    {{ $project->type }}
                                </td>
                            </tr>
                            <tr>
                                <th class="col-sm-4 text-right">Skills:</th>
                                <td>
                                    @if($project->skill)
                                        {{ implode(', ', $project->skill->getSkills()) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ route('admin.project.index') }}" class="btn btn-danger">Cancel</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
