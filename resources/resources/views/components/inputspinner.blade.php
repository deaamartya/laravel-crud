	@extends('spinnermaster')
	<div class='ctrl'>
	  <div class='ctrl__button ctrl__button--decrement'>&ndash;</div>
	  <div class='ctrl__counter'>
	    <input style="width: 100%; border:0px; -moz-appearance:textfield;" class='ctrl__counter-input quantity' type='number' value='1' oninput="myFunction({{$id}})" name='quantity[{{$id}}]' min='1' id='jumlah{{$id}}' required max='{{$stock}}'>
	    <div class='ctrl__counter-num'>0</div>
	  </div>
	  <div class='ctrl__button ctrl__button--increment'>+</div>
	</div>