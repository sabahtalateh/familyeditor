@extends('layouts.master')

@section('content')
    <h4>Добавить человека</h4>

    @include('blocks.formError')

    {!! Form::open(['url' => route('person.store'), 'method' => 'POST']) !!}
    <div class="form-group">
        {!! Form::label('first_name', 'Имя *') !!}
        {!! Form::text('first_name', '', ['class' => 'form-control', 'placeholder' => 'Джодж']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('parental', 'Отчество') !!}
        {!! Form::text('parental', '', ['class' => 'form-control', 'placeholder' => 'Аркадьевич']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('last_name', 'Фамилия') !!}
        {!! Form::text('last_name', '', ['class' => 'form-control', 'placeholder' => 'Жужик']) !!}
    </div>

    <div class="form-group">
        <label for="gender" class="control-label input-group">Пол</label>

        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="gender" value="0">
                <strong>Женский</strong>
            </label>
            <label class="btn btn-default active">
                <input type="radio" name="gender" value="1" checked>
                <strong>Мужеский</strong>
            </label>
        </div>
    </div>

    <div class="form-group">
        {!! Form::submit('Создать',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection