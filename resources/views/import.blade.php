<!DOCTYPE html>
<html>
<head>
    <title>Laravel 6 Search Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>
<body>
    @php
        $test = 'ahmed';
    @endphp
        <div class="container">
        <br>
            <form action="ViewPages" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <label for="from" class="col-form-label">From</label>
                        <div class="col-md-2">

                            <input type="text" class="form-control input-sm" id="from" placeholder="اكتب اسم الشركة" name="from">
                        </div>
                    
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm" name="search">Search</button>
                            <button type="submit" class="btn btn-success btn-sm" name="exportExcel" >export Excel</button>

                        </div>
                    </div>
                </div>
            </form>
            <br>
            <table class="table table-dark">
                <tr>
                <th>id</th>
                <th>full_name</th>
                <th>company_name</th>
                <th>card_img</th>
                <th>QR Code #</th>
                </tr>
                @foreach ($cards as $card)
                <tr>
                    <td>{{$card->id}}</td>
                    <td>{{$card->full_name}}</td>
                    <td>
                        {{$card->company_name}}
                        

                    </td>
                    

                    <td><img src="../../../{{ $card->card_img }}" style="width: 100px" class="img-thumbnail" alt=""></td>
                    <td>{!! QrCode::encoding('UTF-8')->generate(Hash::make($card->full_name . substr($card->national_number, 0, 4).substr($card->ss_num, 0, 4)) )!!}</td>
                </tr>
                @endforeach
            </table>
</div>
</body>
</html>