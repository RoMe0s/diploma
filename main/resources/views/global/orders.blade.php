@extends('layouts.app')

@section('content')
    @customer
        <customer-orders-index></customer-orders-index>
    @else
        <author-orders-index></author-orders-index>
    @endcustomer
@endsection