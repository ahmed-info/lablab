@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    {{ __('Upload Excel File') }}
                    <a href="{{route('index')}}" class="btn btn-primary ml-auto">Return to Cards</a>
                </div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-{{session('alert-type')}}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form action="{{route('card.import')}}" method="POST" class="ml-auto" enctype="multipart/form-data">
                        @csrf
                        {{-- attachment --}}
                        
                        {{-- <div class="custom-file mb-3">
                            <input type="file" name="attachment" class="custom-file-input" id="attachment" required>
                            <label class="custom-file-label" for="attachment">Choose Excel file...</label>
                            @error('attachment')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div> --}}

                        <div class="pt-4">
                        <button type="submit" class="btn btn-sm btn-primary">import</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
