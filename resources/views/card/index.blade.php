@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    {{ __('Cards') }}
                    
                    <form action="/" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <label for="from" class="col-form-label">From</label>
                                <div class="col-md-2">
        
                                    <input type="text" class="form-control input-sm" id="from" placeholder="اكتب اسم الشركة" name="from">
                                    <input type="text" class="form-control input-sm" id="from2" placeholder="اكتب اسم الشركة" name="from2">

                                </div>
                            
                                @if(Admin::find(1)->email == "adsc@admin.com")
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success btn-sm" name="exportExcel" >export Excel</button>
                                    <a href="{{route('card.import')}}" class="btn btn-sm btn-success">Import</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{route('card.export')}}" method="POST" class="ml-auto">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">export</button>

                    </form>
                </div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-{{ session('alert-type') }}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                {{-- <th>warranty number</th> --}}
                                <th>full name</th>
                                {{-- <th>gender</th>
                                <th>birth date</th>
                                <th>release date</th>
                                <th>expiry date</th>
                                <th>national number</th>
                                <th>mother name</th> --}}
                                <th>company name</th>
                                {{-- <th>location</th> --}}
                                <th>image</th>
                                <th>QR Code</th>
                            </tr>
                        </thead>
                        

                        <tbody>

                            @forelse ($cards as $card)
                            <tr>
                            <td>{{$card->id}}</td>
                            {{-- <td>{{$card->ss_num}}</td> --}}
                            <td>{{$card->full_name}}</td>
                                {{-- <td>{{$card->gender}}</td>
                                <td>{{$card->birth_date}}</td>
                                <td>{{$card->release_date}}</td>
                                <td>{{$card->expiry_date}}</td>
                                <td>{{$card->national_number}}</td>
                                <td>{{$card->mother_name}}</td> --}}
                                <td>{{$card->company_name}}</td>
                                {{-- <td>{{$card->location}}</td> --}}
                                {{-- substr($card->ss_num, 0, 4) --}}
                                {{-- .substr($card->national_number, 0, 4) . --}}
                                <td><img src="../../../{{ $card->card_img }}" style="width: 100px" class="img-thumbnail" alt=""></td>
                                <td>{!! QrCode::encoding('UTF-8')->generate(Hash::make($card->full_name . substr($card->national_number, 0, 4).substr($card->ss_num, 0, 4)) )!!}</td>
                                    {{-- <td>{!! QrCode::encoding('UTF-8')->generate($card->full_name) !!} </td> --}}

                                    


                            </tr>
                            @empty
                                <tr>
                                    <td colspan="11">No Cards found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">{{$cards->links()}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
