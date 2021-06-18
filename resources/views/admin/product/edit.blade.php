@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Product Add</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ $action }}" method="POST">
            @if($isEdit==1)
                @method('PUT')
            @endif
            @csrf
            <div class="form-group">
                <label for="fname">Name*:</label>
                <input type="text" id="name" class="form-control col-md-6" name="name" value="@if($isEdit==1) {{ $product->name }} @else {{ old('name') }} @endif">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="lname">Category*:</label>
                {{-- <select name="category_id"> --}}
                <x-adminlte-select name="category_id" class="form-control col-md-6">
                    <option>--Select--</option>
                    @if(!empty($categories))
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($isEdit==1 && $category->id==$product->category_id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                    @endif
                </x-adminlte-select>
                {{-- </select> --}}
                @if ($errors->has('category_id'))
                    <span class="text-danger">{{ $errors->first('category_id') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="fname">Price:</label>
                <input type="text" id="price" class="form-control col-md-6" name="price" value="@if($isEdit==1) {{ $product->price }} @else {{ old('price') }} @endif">
                @if ($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="fname">Description:</label>
                <textarea id="description" class="form-control col-md-6" name="description">@if($isEdit==1) {{ $product->description }} @else {{ old('description') }} @endif</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="lname">Status:</label>
                <select name="status" class="form-control col-md-6">
                    <option>--Select--</option>
                    <option value="Active" @if($isEdit==1 && $product->status=='Active') selected @endif>Active</option>
                    <option value="Inactive" @if($isEdit==1 && $product->status=='Inactive') selected @endif>Inactive</option>
                </select>
            </div>
            <input type="submit" value="Submit" class="btn btn-primary m-1">
        </form>
    </div>
</div>
@stop