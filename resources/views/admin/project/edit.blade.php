@extends('layouts.app')

@push('styles')
<link href="{{ asset('libs/datetimepicker-master/build/jquery.datetimepicker.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Project</div>

                <div class="card-body">

                    {!! Form::model($project, ['route' => ['admin.project.update', $project->id], 'class' => 'form-horizontal', 'method' => 'patch', 'files' => 'true']) !!}

                    <div class="form-group row">
                        {!! Form::label('user', 'User: *', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::select('user', \App\User::all()->pluck('name', 'id')->toArray(), $project->user_id, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('user', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('title', 'Title: *', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('title', null, ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control', 'required' => 'required', 'placeholder' => 'Title']) !!}
                            {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('description', 'Description: *', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('description', null, ['class' => $errors->has('description') ? 'form-control is-invalid' : 'form-control', 'required' => 'required', 'maxlength' => '2000', 'placeholder' => 'Description']) !!}
                            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('organization', 'Organization:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('organization', null, ['class' => $errors->has('organization') ? 'form-control is-invalid' : 'form-control', 'placeholder' => 'Organization']) !!}
                            {!! $errors->first('organization', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('start', 'Date Start:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('start', null, ['class' => $errors->has('start') ? 'form-control is-invalid' : 'form-control']) !!}
                            {!! $errors->first('start', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('end', 'Date End:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('end', null, ['class' => $errors->has('end') ? 'form-control is-invalid' : 'form-control']) !!}
                            {!! $errors->first('end', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('type', 'Type: *', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('type', null, ['class' => $errors->has('type') ? 'form-control is-invalid' : 'form-control', 'required' => 'required', 'placeholder' => 'Type']) !!}
                            {!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('skills', 'Skills: *', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            {!! Form::textarea('skills', implode("\n", $project->skill->getSkills()), ['class' => $errors->has('skills') ? 'form-control is-invalid' : 'form-control', 'required' => 'required', 'placeholder' => 'Skills (1 per line)']) !!}
                            {!! $errors->first('skills', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('attachments', 'Attachments: ', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                        <div class="col-sm-7">
                            @if($project->getAttachments())
                                <div style="padding-bottom: 15px;">
                                    @foreach($project->getAttachments() as $item)
                                        <a href="{{ asset($item->path) }}" download class="btn btn-dark btn-xs text-uppercase">{{ $item->extension }}</a>
                                    @endforeach
                                </div>
                            @endif
                            {!! Form::file('attachments[]', ['class' => $errors->has('attachments') ? 'form-control is-invalid' : 'form-control', 'multiple', 'accept' => 'image/jpeg,image/png,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf']) !!}
                            {!! $errors->first('attachments', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <a href="{{ route('admin.project.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                        <div class="col-sm-6 text-right">
                            {!! Form::submit('Update Project', ['class' => 'btn btn-info']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('libs/datetimepicker-master/build/jquery.datetimepicker.full.js') }}"></script>
<script>
    $(function () {
        $('#start, #end').datetimepicker({
            format:'Y-m-d H:m:s',
        });
    });
</script>
@endpush
