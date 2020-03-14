@extends('selectmaster')

@section('judultable','Customer')

@section('btn-insert')
<a href="{{ route('customer.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Phone</th>
  <th>Email</th>
  <th>Street</th>
  <th>City</th>
  <th>State</th>
  <th>Zip Code</th>
@endsection

@section('data')

@foreach($customers as $c)
<tr>
	<td>{{ $c->customer_id }}</td>
	<td>{{ $c->first_name }}</td>
	<td>{{ $c->last_name }}</td>
	<td>0{{ $c->phone }}</td>
	<td>{{ $c->email }}</td>
	<td>{{ $c->street }}</td>
	<td>{{ $c->city }}</td>
	<td>{{ $c->state }}</td>
	<td>{{ $c->zip_code }}</td>
  <td>
    @include('actbtn', 
    array(
    'editlink' => 'customer.edit',
    'id' => $c -> customer_id,
    'dellink' => 'customer.destroy',
    'name' => $c -> first_name,
    'entity' => 'customer',
    'Entity' => 'Customer'))
  </td>
</tr>
@endforeach
@endsection