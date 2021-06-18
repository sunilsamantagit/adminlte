@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    @if($isDeleted==1)
        <x-slot name="title">
            Deleted Product List
        </x-slot>
    @else
        <x-slot name="title">
            Product List
        </x-slot>
    @endif
    @if (session('status'))
        <x-alert type="success" :message="session('status')"/>
    @endif
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @if($isDeleted==0)
            <a href="{{ URL::to('admin/products/create') }}" class="btn btn-primary m-1">Add Product</a>
            <a href="{{route('products.trashList')}}" class="btn btn-primary m-1">Trash List</a>
        @endif
        <table class="table table-bordered ">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @if(count($products)>0)
                @foreach($products as $product)
                <?php //dd($product->category); ?>
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->status }}</td>
                    <td>
                        @if($isDeleted==0)
                        <a href="{{route('products.edit', $product->id)}}" class="btn btn-primary m-1">Edit</a>
                        <form class="d-inline" action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @method("DELETE")
                            @csrf
                            <button class="btn btn-danger m-1">Delete</button>
                        </form>
                        @else
                            <a href="{{route('products.permanentDelete', $product->id)}}" class="btn btn-danger m-1">Permanently Delete</a>
                            <a href="{{route('products.restoreDeleted', $product->id)}}" class="btn btn-primary m-1">Restore</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">No Records Found</td>
                </tr>
            @endif
        </table>
    </div>
</div>
@stop