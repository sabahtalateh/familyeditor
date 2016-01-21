@extends('layouts.master')

@section('headscripts')
    <script src="/js/vue.min.js"></script>
    <script src="/js/vue-resource.min.js"></script>

    <style>
        .error {
            color: red;
        }

        .possible-parents {
            display: inline-block;
            padding-right: 16px;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <h4>Добавить связь родители-ребёнок</h4>
    <p>Чтобы добавить человека в связь введите его имя и тыкните на плашку с его именем, если просто введете имя то в связь человек не добавится</p>
    @include('blocks.formError')
    <div id="create_children_form">
        {!! Form::open(['url' => route('person.children.store'), 'method' => 'POST']) !!}
        <div class="form-group">
            {!! Form::label('father_search', 'Отец') !!}
            <span class="error" v-if="!person.father">*</span>
            {!! Form::text('father_search', '', ['class' => 'form-control', 'placeholder' => 'Отец', 'v-model' => 'person.father', 'v-on:keyup' => "fetchPersons(person.father, 1)"]) !!}
            {!! Form::hidden('father', '', ['v-model' => 'personToAdd.father']) !!}
            <div v-for="item in possible.fathers" class="possible-parents">
                <h2 class="element" v-on:click="setToForm"><span data-id="@{{ item.id }}" data-role="father"
                                                                 class="label label-primary">@{{ item.first_name }} @{{ item.last_name }}</span>
                </h2>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('mother_search', 'Мать') !!}
            <span class="error" v-if="!person.mother">*</span>
            {!! Form::text('mother_search', '', ['class' => 'form-control', 'placeholder' => 'Мать', 'v-model' => 'person.mother', 'v-on:keyup' => "fetchPersons(person.mother, 0)"]) !!}
            {!! Form::hidden('mother', '', ['v-model' => 'personToAdd.mother']) !!}
            <div v-for="item in possible.mothers" class="possible-parents">
                <h2 class="element" v-on:click="setToForm"><span data-id="@{{ item.id }}" data-role="mother"
                                                                 class="label label-primary">@{{ item.first_name }} @{{ item.last_name }}</span>
                </h2>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('child_search', 'Отпрыск') !!}
            <span class="error" v-if="!person.child">*</span>
            {!! Form::text('child_search', '', ['class' => 'form-control', 'placeholder' => 'Отпрыск', 'v-model' => 'person.child', 'v-on:keyup' => "fetchPersons(person.child)"]) !!}
            {!! Form::hidden('child', '', ['v-model' => 'personToAdd.child']) !!}
            <div v-for="item in possible.children" class="possible-parents">
                <h2 class="element" v-on:click="setToForm"><span data-id="@{{ item.id }}" data-role="child"
                                                                 class="label label-primary">@{{ item.first_name }} @{{ item.last_name }}</span>
                </h2>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" :disabled="errors">Создать</button>
            {{--            {!! Form::submit('Создать',['class' => 'btn btn-primary', 'v-attr' => 'disabled:true']) !!}--}}
        </div>
        {!! Form::close() !!}

    </div>
    <script src="/js/people.js"></script>
@endsection
