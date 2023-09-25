@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <a href="{{ route('plans.create') }}" class="btn btn-info"><i class="material-icons">add</i> Create Plan</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
                <i class="material-icons">store</i>
            </div>
            <h4 class="card-title">Plans</h4>
        </div>
        <div class="card-body">
            <div class="material-datatables">
                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Picture</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                     @foreach ($plans as $plan)
                     <tr>
                        <td>{{$plan->name}}</td>
                        <td>{{$plan->price}}</td>
                        <td>{{$plan->description}}</td>
                        <td>
                            @if ($plan->image)
                            <img src="{{ asset('images/plan/' . $plan->image) }}" alt="{{ $plan->name }} Image" width="100">
                            @else
                                No image available
                            @endif
                        </td>
                        <td>
                           <a href="{{ route('plans.show', $plan->id) }}"><button class="btn btn-primary">Show</button></a>
                           <a href="{{ route('plans.edit', $plan->id) }}"><button class="btn btn-info">Edit</button></a>
                           <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </td>
                     </tr>
                     @endforeach
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer-js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}" type="text/javascript"></script>

@endsection