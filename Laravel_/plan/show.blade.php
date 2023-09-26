@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Plan Details</h1>

        <h2>{{ $plan->name }}</h2>
        <p>Description: {{ $plan->description }}</p>
        <p>Price: ${{ $plan->price }}</p>
        <!-- Add other plan details here -->

        <a href="{{ route('plans.index') }}" class="btn btn-primary">Back to Plans</a>
    </div>
@endsection