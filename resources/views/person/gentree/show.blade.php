@extends('layouts.master')

@section('headscripts')
    <script src="/js/cytoscape.min.js"></script>

    <style>
        #cy {
            width: 90%;
            height: 70%;
            margin: auto;
            display: block;
        }
    </style>
@endsection

@section('content')
    <h4>Генеалогическое дерево</h4>
    <p>Если связи перемешались то узлы можно двигать мышкой</p>
    <p>Красный круг - элемент для которого строится дерево</p>
    <div id="cy"></div>
    <script src="/js/buildGraph.js"></script>
@endsection

@include ('footer')