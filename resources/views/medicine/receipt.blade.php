@php
    use App\Medicine;
@endphp
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <style>
        @media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
    </style>
    <title>Print Prescrition | {{$presc->id}}</title>
  </head>
  <body style="min-height: 1480px;">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="width: 100%; height: 180px;"><img src="{{asset('images/prescriptions-bg-1.png')}}" alt="" style="width: 100%; height: 180px;"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" style="background-image: url({{asset('images/prescriptions-bg-3.png')}});background-repeat: no-repeat;background-position: center;background-repeat: no-repeat;background-size: cover;width: 100%; min-height: 1200px;">
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <h6 style="display: inline-block">Patient Name:</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{$presc->patient->name}}<br>
                        <h6 style="display: inline-block">Registration No.:</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{$presc->patient->id}}<br>
                        <h6 style="display: inline-block">Prescribed By:</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Dr.{{ucwords($presc->doctor->name)}}
                    </div>
                    <div class="col-md-6">
                        <h6 style="display: inline-block">Gender:</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{$presc->patient->sex}}<br>
                        <h6 style="display: inline-block">Date Of Birth:</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{$presc->patient->bod}}<br>
                        <h6 style="display: inline-block">Contact No:</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{$presc->patient->telephone}}
                    </div>
                    <div class="col-md-12">
                        <h6 style="display: inline-block">Address:</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{$presc->patient->address}}
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <table class="mt-4 w-100">
                    <colgroup>
                        <col style="width: 50%" />
                        <col style="width: 50%" />
                       
                      </colgroup>
                      <tr style="border-bottom: 1px solid #333;">
                        <th style="padding-bottom: 10px;">Medicine</th>
                        <th style="padding-bottom: 10px;">Description</th>
                      </tr>
                @foreach ($medicines as $med)
                        <tr>
                            <td style="padding-top: 10px;">{{Medicine::find($med->medicine_id)->name_english}}</td>
                            <td style="padding-top: 10px;">{{$med->note}}</td>
                        </tr>
                    @endforeach
                </table>
                <br>
                <br>
                <br>
                
                <button onclick="window.print()" class="btn no-print btn-lg btn-info">Print <i class="fas fa-print"></i></button>
                <a href="{{route('issueMedicineView')}}" class="btn btn-dark btn-lg no-print">Go Back</a>
                
                <div class="row" style="position:absolute;bottom:100px; left:0;right:0;">
                    <div class="col-md-6">Date of Issue: {{explode(" ",$presc->created_at)[0]}}</div>
                    <div class="col-md-6 text-right">Issued By: {{ucwords(Auth::user()->name)}}</div>
                    <p class="col-md-12 mt-5 small text-center">This Is An Automated Computer Generated Slip</p>
                </div>
                <div class="col-md-12" style="background-image: url({{asset('images/prescriptions-bg-2.png')}});background-repeat: no-repeat;background-position: center;background-repeat: no-repeat;background-size: cover;width: 100%; height: 50px;position:absolute;bottom:0;"></div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

  </body>
</html>