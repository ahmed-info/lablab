
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    {{ __('Cards') }}
                    
                    
                </div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-{{ session('alert-type') }}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form action="{{route('index')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="from" placeholder="اكتب اسم الشركة" name="from" required>
                                </div>
                            
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-sm" name="exportExcel">export Excel</button>

                                     <a href="{{route('card.upload')}}" class="btn btn-sm btn-success">Import</a>

                                </div>
                            </div>
                        </div>
                    </form>
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
                                <th>QR enCode</th>
                                <th>QR deCode</th>
                            </tr>
                        </thead>
                        

                        <tbody>

                            @forelse ($cards as $card)
                            <tr>
                            <td>{{$card->id}}</td>
                            {{-- <td>{{$card->warranty_number}}</td> --}}
                            <td>{{$card->full_name}}</td>
                                {{-- <td>{{$card->gender}}</td>
                                <td>{{$card->birth_date}}</td>
                                <td>{{$card->release_date}}</td>
                                <td>{{$card->expiry_date}}</td>
                                <td>{{$card->national_number}}</td>
                                <td>{{$card->mother_name}}</td> --}}
                                <td>{{$card->company_name}}</td>
                                {{-- <td>{{$card->location}}</td> --}}
                                {{-- substr($card->warranty_number, 0, 4) --}}
                                {{--$qr = QrCode::errorCorrection('L')->size(250)->encoding('UTF-8')->generate(--}}

                                {{-- .substr($card->national_number, 0, 4) . --}}
                                <td><img src="../../../{{ $card->card_img }}" style="width: 100px" class="img-thumbnail" alt=""></td>
                                <td>
                                    <img src="{{asset('qr_code/'.Str::slug($card->full_name).'.png')}}" alt="">
                                    {!! QrCode::errorCorrection('L')->size(150)->encoding('UTF-8')->generate(
                                    $card->qr_code) !!}
                                </td>
                                    {{-- <td>{!! QrCode::encoding('UTF-8')->generate($card->full_name) !!} </td> --}}
                                    {{-- <td>{!! QrCode::encoding('UTF-8')->generate(Hash::make($card->full_name)) !!} </td> --}}
                                <td>
                                    {!! QrCode::errorCorrection('L')->size(150)->encoding('UTF-8')->generate($card->qr_code)!!}
                                    {{-- <img src="../../../{{ $card->qr_code }}" style="width: 100px" class="img-thumbnail" alt=""> --}}
                                </td>

                                    


                            </tr>
                            @empty
                                <tr>
                                    <td colspan="11">No Cards found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                {{-- <td colspan="11">{{$cards->links()}}</td> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
