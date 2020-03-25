{!! Form::hidden('sort', $data['sort'], ['id' => 'filterSort']) !!}
{!! Form::hidden('name', $data['name'], ['id' => 'filterName']) !!}
<table class="table table-hover">
    <thead>
    <tr>
        @php($sort = $data['sort'] == 'asc' ? 'desc' : 'asc')
        <th scope="col"><a href="{{ route('admin.project.index', ['name' => 'title', 'sort' => $sort, 'filter' => isset($data['filter']) ? $data['filter'] : '']) }}" class="sort">Title {!! $data['name'] == 'title' ? "<i class='fa fa-sort-{$sort}' aria-hidden='true' style='color:red'></i>" : '' !!}</a></th>
        <th scope="col"><a href="{{ route('admin.project.index', ['name' => 'organization', 'sort' => $sort, 'filter' => isset($data['filter']) ? $data['filter'] : '']) }}" class="sort">Organization {!! $data['name'] == 'organization' ? "<i class='fa fa-sort-{$sort}' aria-hidden='true' style='color:red'></i>" : '' !!}</a></th>
        <th scope="col"><a href="{{ route('admin.project.index', ['name' => 'type', 'sort' => $sort, 'filter' => isset($data['filter']) ? $data['filter'] : '']) }}" class="sort">Type {!! $data['name'] == 'type' ? "<i class='fa fa-sort-{$sort}' aria-hidden='true' style='color:red'></i>" : '' !!}</a></th>
        <th scope="col"><a href="{{ route('admin.project.index', ['name' => 'user', 'sort' => $sort, 'filter' => isset($data['filter']) ? $data['filter'] : '']) }}" class="sort">User {!! $data['name'] == 'user' ? "<i class='fa fa-sort-{$sort}' aria-hidden='true' style='color:red'></i>" : '' !!}</a></th>
        <th width="180">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @forelse($projects as $project)
        <tr>
            <td>{{ $project->title }}</td>
            <td>{{ $project->organization }}</td>
            <td>{{ $project->type }}</td>
            <td>{{ $project->user->name }}</td>
            <td>
                <a href="{{ route('admin.project.show', $project->id) }}" class="btn btn-success btn-xs" title="Show Project"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <a href="{{ route('admin.project.edit', $project->id) }}" class="btn btn-primary btn-xs" title="Edit Project"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                {!! Form::open(['method'=>'delete', 'route' => ['admin.project.destroy', $project->id], 'style' => 'display:inline']) !!}
                {!! Form::button('<i class="fa fa-trash"></i>', array(
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-xs',
                        'title' => 'Delete Project',
                        'onclick'=>'return confirm("Confirm?")'
                ))!!}
                {!! Form::close() !!}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No records</td>
        </tr>
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5">
            {{ $projects->render() }}
        </td>
    </tr>
    </tfoot>
</table>
