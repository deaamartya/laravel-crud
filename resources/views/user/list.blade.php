@extends('selectmaster')

@section('judultable','User')

@section('btn-insert')
<a href="{{ route('user.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Phone</th>
  <th>Email</th>
  <th>Job Status</th>
@endsection

@section('data')

@foreach($users as $c)
<tr>
	<td>{{ $c->user_id }}</td>
	<td>{{ $c->first_name }}</td>
	<td>{{ $c->last_name }}</td>
	<td>0{{ $c->phone }}</td>
	<td>{{ $c->email }}</td>
	<td>{{ $c->job_status }}</td>
  <td>
    @include('actbtn', 
    array(
    'editlink' => 'user.edit',
    'id' => $c -> user_id,
    'dellink' => 'user.destroy',
    'name' => $c -> first_name,
    'entity' => 'user',
    'Entity' => 'User'))
  </td>
</tr>
@endforeach
@endsection