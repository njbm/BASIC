@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">store</i>
                    </div>
                    <h4 class="card-title">Create a plan</h4>
                </div>
                <div class="card-body ">
                    <form action="{{ route('plans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Plan Image</label>
                            <input type="file" name="image" id="image" accept="image/*">
                            <br><br>

                            <label for="image">Plan Name</label>
                            <input type="text" name="name" class="form-control">

                            <label for="image">Plan Price</label>
                            <input type="text" name="price" class="form-control">

                            <label for="image">Plan Description</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-fill btn-rose">Create</button>
                        <a href="{{ route('plans.index') }}" class="btn btn-fill btn">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection