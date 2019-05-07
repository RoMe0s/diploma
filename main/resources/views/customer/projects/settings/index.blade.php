@extends('layouts.app')

@section('content')
    <customer-projects-settings-index :project="{{ $project }}"/>
@endsection