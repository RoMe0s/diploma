@extends('layouts.app')

@section('content')
    @customer
        <customer-balance></customer-balance>
    @else
        <author-balance></author-balance>
    @endcustomer
@endsection