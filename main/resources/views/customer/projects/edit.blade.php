@extends('layouts.app')

@section('content')
    <customer-projects-edit :project="{{ $project }}"></customer-projects-edit>
@endsection