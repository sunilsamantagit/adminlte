@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Category Add</h1>
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
                <input type="text" id="name" class="form-control col-md-6" name="name" value="@if($isEdit==1) {{ $category->name }} @else {{ old('name') }} @endif">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="lname">Display In Menu*:</label>
                <select name="display_in_menu" class="form-control col-md-6">
                    <option>--Select--</option>
                    <option value="1" @if($isEdit==1 && $category->display_in_menu==1) selected @endif>Yes</option>
                    <option value="0" @if($isEdit==1 && $category->display_in_menu==0) selected @endif>No</option>
                </select>
                @if ($errors->has('display_in_menu'))
                    <span class="text-danger">{{ $errors->first('display_in_menu') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="lname">Status:</label>
                <select name="status" class="form-control col-md-6">
                    <option>--Select--</option>
                    <option value="Active" @if($isEdit==1 && $category->status=='Active') selected @endif>Active</option>
                    <option value="Inactive" @if($isEdit==1 && $category->status=='Inactive') selected @endif>Inactive</option>
                </select>
            </div>
            <input type="submit" value="Submit" class="btn btn-primary m-1">
        </form>
    </div>
</div>
@stop