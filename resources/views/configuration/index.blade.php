@extends('templates.html.html')

@section('content')
    <form method="POST" action="{{ route('configure.store') }}">
        @csrf
        @include('templates.html.forms.text_input', [
            'field' => [
                'name' => 'name',
                'label' => 'User\'s Full Name',
                'value' => '',
                'placeholder' => 'User\'s Full Name',
            ],
        ])
        @include('templates.html.forms.text_input', [
            'field' => [
                'name' => 'email',
                'label' => 'User\'s Primary Email',
                'value' => '',
                'placeholder' => 'Email',
            ],
        ])
        @include('templates.html.forms.password_input')
        @include('templates.html.forms.select', [
            'field' => [
                'name' => 'database.default',
                'label' => 'Database Type',
                'value' => '',
                'options' => [
                    'sqlite' => 'SQLite',
                    'mysql' => 'MySQL',
                ],
            ],
        ])
        <button type="submit" class="btn btn-primary">
            {{ __('Save') }}
        </button>
    </form>
@endsection