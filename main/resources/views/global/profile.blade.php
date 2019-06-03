@extends('layouts.app')

@section('content')
    @customer
        <customer-profile></customer-profile>
    @else
        <author-profile></author-profile>
    @endcustomer
@endsection