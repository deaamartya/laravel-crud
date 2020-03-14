@extends('selectmaster')

@section('judultable','Kategori')

@section('btn-insert')
<a href="{{ route('categories.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>Name</th>
@endsection

@section('data')

@foreach($categories as $c)
<tr>
	<td>{{ $c -> category_id }}</td>
	<td>{{ $c -> category_name }}</td>
  <td>
    @include('actbtn', 
    array(
    'editlink' => 'categories.edit',
    'id' => $c -> category_id,
    'dellink' => 'categories.destroy',
    'name' => $c -> category_name,
    'entity' => 'kategori',
    'Entity' => 'Kategori'))
  </td>
</tr>
@endforeach
@endsection