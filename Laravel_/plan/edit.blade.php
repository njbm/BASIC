@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">Edit</i>
                    </div>
                    <h4 class="card-title">Edit the plan</h4>
                </div>
                <div class="card-body ">
                    <form action="{{ route('plans.update', ['plan' => $plan->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="old_img">Current Image</label><br> 

                            @if ($plan->image)
                                <img src="{{ asset('images/plan/' . $plan->image) }}" alt="Current Image" width="100" id=old_img>
                            @endif
                            <br><br>
                            <label for="image" class="text-success">Click to Upload New Image</label>
                            <input type="file" name="image" id="image" accept="image/*">
                            <br>

                            <label for="name">Plan Name</label>
                            <input type="text" name="name" class="form-control" value="{{$plan->name}}" id="name">

                            <label for="price">Plan Price</label>
                            <input type="text" name="price" class="form-control" value="{{$plan->price}}" id="price">

                            <label for="desc">Plan Description</label>
                            <input type="text" name="description" class="form-control" value="{{$plan->description}}" id="desc">
                        </div>
                        <button type="submit" class="btn btn-fill btn-rose">Update</button>
                        <a href="{{ route('plans.index') }}" class="btn btn-fill btn">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection