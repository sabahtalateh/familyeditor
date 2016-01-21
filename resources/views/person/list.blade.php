@extends('layouts.master')

@section('content')
    <h4>Список людей</h4>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Имя</td>
                <td>Отчество</td>
                <td>Фамилия</td>
                <td>Пол</td>
            </tr>
            </thead>

            @foreach ($persons as $person)

                <tr>
                    <td>{{ $person->first_name }}</td>
                    <td>{{ $person->parental }}</td>
                    <td>{{ $person->last_name }}</td>

                    @if($person->gender == 1)
                        <td style="font-size: 2em; line-height: 1em; color: #337ab7">
                            &#x2642;
                        </td>
                    @else
                        <td style="font-size: 2em; line-height: 1em; color: #c12e2a">
                            &#x2640;
                        </td>
                    @endif
                    <td>
                        <a href="{{ route('person.gentree.show', $person->id) }}" class="btn">Построить дерево</a>
                    </td>
                </tr>

            @endforeach

        </table>
    </div>



    {{$persons->links() }}
@endsection

