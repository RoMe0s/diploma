@extends('layouts.app')

@section('content')
    @inject('role', 'App\Constants\Role')
    <auth-register :roles="{{ json_encode($role::REGISTER) }}"></auth-register>
@endsection
