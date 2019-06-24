@extends('layouts.app')

@section('content')
    <customer-tasks-edit :id="{{ $id }}"/>
@endsection

@push('scripts')
    <script src="{{ asset('js/chunks/editor.js') }}" defer></script>
@endpush
