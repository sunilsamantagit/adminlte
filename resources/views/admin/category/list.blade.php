@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    @if($isDeleted==1)
            Deleted Category List
    @else
            Category List
    @endif
    @if (session('status'))
        <x-alert type="success" :message="session('status')"/>
    @endif
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @if($isDeleted==0)
            <a href="{{ URL::to('admin/categories/create') }}" class="btn btn-primary m-1">Add Category</a>
            <a href="{{route('categories.trashList')}}" class="btn btn-primary m-1">Trash List</a>
        @endif
        <table class="table table-bordered ">
            <tr>
                <th>Name</th>
                <th>Display In Menu</th>
                <th>Number Of Product</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @if(count($categories)>0)
                @foreach($categories as $category)
                <?php //if($category->id == 16) {echo count($category->products);die;} ?>
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>@if($category->display_in_menu==1) Yes @elseif($category->display_in_menu==0) No @endif</td>
                    <td>{{ count($category->products) }}</td>
                    <td>{{ $category->status }}</td>
                    <td>
                        @if($isDeleted==0)
                        <a href="{{route('categories.edit', $category->id)}}" class="btn btn-primary m-1">Edit</a>
                            <form class="d-inline" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-danger m-1">Delete</button>
                            </form>
                            <a href="{{route('categories.show', $category->id)}}" class="btn btn-primary m-1">Show All</a>
                        @else
                            <a href="{{route('categories.PermanentDelete', $category->id)}}" class="btn btn-danger m-1">Permanently Delete</a>
                            <a href="{{route('categories.restoreDeleted', $category->id)}}" class="btn btn-primary m-1">Restore</a>
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