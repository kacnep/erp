@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Projects</div>

                    <div class="card-body" >
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('alert'))
                            <div class="alert alert-success" role="alert">
                                {{ session('alert') }}
                            </div>
                        @endif

                            <div class="row form-group">
                                <div class="col-auto">
                                    <a href="{{ route('admin.project.create') }}" class="btn  btn-primary">Create Project</a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.project.downloadExample') }}" class="btn btn-info">Download Example</a>
                                </div>
                                <div class="col-auto">

                                    {!! Form::open(['route' => 'admin.project.importExcel', 'class' => 'form-horizontal', 'files' => 'true']) !!}

                                    <div class="row">
                                        <div class="col">
                                            <div class="custom-file">
                                                {!! Form::file('customFile', ['class' => 'custom-file-input', 'id'  =>'customFile', 'accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel', 'required']) !!}
                                                {!! Form::label('customFile', 'Choose file', ['class' => 'custom-file-label']) !!}
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary mb-2">Import</button>
                                        </div>
                                    </div>

                                    {!! Form::close() !!}

                                </div>
                            </div>

                        <div class="row form-group">
                            <div class="col-sm-12 text-right">
                                {!! Form::text('filter', isset($data['filter']) ? $data['filter'] : null, ['class' => 'form-control', 'id' => 'filter', 'placeholder' => 'Title / Organization / Type']) !!}
                            </div>
                        </div>

                        <div id="ajax-loader">
                            @include('admin.project.include.ajax-loader', compact('preojects', 'data'))
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                {!! Form::open(['method'=>'delete', 'route' => ['admin.project.deleteAllProjects'], 'style' => 'display:inline']) !!}
                                {!! Form::button('<i class="fa fa-trash"></i> Delete All Projects', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger btn-xs',
                                        'title' => 'Delete All Projects',
                                        'onclick'=>'return confirm("Confirm?")'
                                ))!!}
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        $(document).on('click', 'a.sort, a.page-link', function (e) {
            e.preventDefault();

            $.ajax({
                type: "GET",
                'url': $(this).attr('href'),
            }).done(function (response) {
                $('#ajax-loader').html(response.innerHtml);
            }).fail(function () {
                alert('error');
            });
        });

        $(document).on('keyup', '#filter', function () {
            $.ajax({
                type: "GET",
                'url': '{{ route('admin.project.index') }}',
                'data': {
                    'filter': $(this).val(),
                    'sort': $('#filterSort').val(),
                    'name': $('#filterName').val()
                }
            }).done(function (response) {
                $('#ajax-loader').html(response.innerHtml);
            }).fail(function () {
                alert('error');
            });
        });
    });
</script>
@endpush
