@extends('template.main')

@section('title', $title)

@section('content_title',__('Add Receipt'))

@section('content_description',__('Enter Patient\'s Medicine Receipt'))
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection

@section('main_content')
{{--  Medicines registration  --}}

<script src="/js/WebCam/webcam.js"></script>

<div @if (session()->has('regpsuccess') || session()->has('regpfail')) style="margin-bottom:0;margin-top:3vh" @else
    style="margin-bottom:0;margin-top:8vh" @endif class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        @if (session()->has('prescriptionSuccess'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{session()->get('prescriptionSuccess')}}
        </div>
        @endif
        @if (session()->has('prescriptionFail'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            {{session()->get('prescriptionFail')}}
        </div>
        @endif
    </div>
    <div class="col-md-1"></div>

</div>

<div class="row">
    <!-- right column -->
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{__('Prescription\'s Info')}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="{{ route('register_presc') }}" class="form-horizontal">
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">{{__('Patient Name')}} <span
                                style="color:red">*</span></label>
                        <div class="col-sm-6 mr-0 pr-0">
                            <select required class="form-control" name="p_id">
                                <option selected disabled value="">Select Patient Name</option>
                                @foreach($patient as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">{{__('Doctor Name')}} <span
                                style="color:red">*</span></label>
                        <div class="col-sm-6 mr-0 pr-0">
                            <select required class="form-control" name="d_id">
                                <option selected disabled value="">Enter Doctor Name</option>
                                @foreach($doctor as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="inputEmail3" class="col-sm-4 control-label" style="position: relative">{{__('Appointment ID')}} <span
                                style="color:red; position: absolute;">&nbsp;*</span></label>
                        <div class="col-sm-6 mr-0 pr-0">
                            <select required class="form-control" name="a_id">
                                <option selected disabled value="">Appointment Number</option>
                                @foreach($appointment as $a)
                                <option value="{{$a->id}}">{{$a->number}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="inputEmail3" class="col-sm-4 control-label">{{__('Status')}}</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="status" id="status" value="NO" style="position: absolute;">
                            <a href="javascript:void(0);" id="Unmark" class="btn btn-warning">Mark as Issue</a>
                            <a href="javascript:void(0);" id="Mark" class="btn btn-success" style="display: none;">Issued</a>
                        </div>
                    </div>
                    <br>
                    <div class="box-header with-border">
                        <h4 class="box-title" style="font-size: 15px !important;">{{__('Add Medicines')}}</h4>
                    </div>
                    <div class="form-group" id="medicineBlock">
                    </div>
                    <div class="form-group">
                        <div class="col-sm-11">
                            <span class="ml-auto">
                                <a href="javascript:void(0);" id="addMore" class="btn btn-success pull-right">+</a>
                            </span>
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <h4 class="box-title" style="font-size: 15px !important;">{{__('Status Of Patient')}}</h4>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="BoillingPoint" class="col-sm-4 control-label">{{__('BP')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="bp" placeholder="Measured blood pressure of Patient">
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="cholestrol" class="col-sm-4 control-label">{{__('Cholestrol')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="chol" placeholder="Enter Cholestrol">
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="Sugar" class="col-sm-4 control-label">{{__('Sugar')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="sugar" placeholder="Sugar of the Patient">
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="Diagnosis" class="col-sm-4 control-label">{{__('Diagnosis')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="diag" placeholder="Diagnosis Info">
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" name="submit" class="btn btn-info pull-right" value="{{__('Register')}}">
                        <input type="reset" name="reset" class="btn btn-default" value="{{__('Cancel')}}">
                    </div>
                    <!-- /.box-footer -->
                </div>
            </form>

        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            var counter = 1;
            $(document).ready(function(){
                $("#addMore").click(function () {
                    var medRow = $(document.createElement('div')).attr("id",'input'+counter).css("padding-bottom","50px");
                    var iRow = '<div class="col-sm-2"></div><div class=\"col-sm-4 mr-0 pr-0\"><select required class=\"form-control\" id=\"medName'+counter+'\" name=\"med_name[]\"><option selected disabled value="">Select Medicine Name</option>@foreach($medicine as $m)<option value="{{$m->id}}">{{$m->name}}</option>@endforeach</select></div><div class=\"col-sm-4\"><input type=\"text\" class=\"form-control\" id=\"medDesc['+counter+']\" name=\"med_desc[]\" placeholder=\"Medicine Description\"></div><div class=\"col-sm-1\"><span class=\"ml-auto\"><a href=\"javascript:void(0);\" onclick=\"medRemove('+counter+')\" class=\"btn btn-danger pull-right remove_counter\">x</a></span></div>';
                    medRow.after().html(iRow);
                    medRow.appendTo("#medicineBlock");
                    counter++;
                });
            });
            $('#Unmark').click(function () {
                if(document.getElementById('status').value == "NO") {
                    $('#Unmark').hide();
                    $('#Mark').show();
                    document.getElementById('status').value = "YES";
                }
            });
            $('#Mark').click(function () {
                if(document.getElementById('status').value == "YES") {
                    $('#Unmark').show();
                    $('#Mark').hide();
                    document.getElementById('status').value = "NO";
                }
            });
            function medRemove(e){
                x = "input" + e;
                robj = document.getElementById(x);
                robj.remove();
            };
            $('#datepicker').datepicker({
                autoclose: true
            });

            function camStart(){
                Webcam.set({
                width: 200,
                height: 150,
                image_format: 'png',
                jpeg_quality: 100
                });
                Webcam.attach( '#my_camera' );
            }

            var data;

            function takeSnapshot() {
                Webcam.snap( function(data_uri) {
                    data=data_uri;
                    document.getElementById('results').innerHTML ='<img style="width:200px;height:150px" src="'+data_uri+'"/>';
                    $("#save_btn").removeAttr("disabled");
                });
            }

            function saveSnap(){
                document.getElementById('regp_photo').setAttribute("value", data);
                $("#photo_icon").fadeIn();
                $("#photo_btn").addClass("btn-success");
                $("#photo_btn_text").text("{{__('Photo Taken')}}");
                $("#photo_btn").removeClass("bg-navy");
                Webcam.reset();
            }

            function cancelSnap(){
                document.getElementById('regp_photo').removeAttribute("value");
                $("#photo_icon").fadeOut();
                $("#photo_btn").removeClass("btn-success");
                $("#photo_btn").addClass("bg-navy");
                if(data==null){
                    $("#save_btn").attr("disabled", "disabled");
                }
                Webcam.reset();
            }

        </script>



            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" onclick="Webcam.reset()"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">{{__('Take The Photo')}}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5 mr-3">
                                    <h4>{{__('Live Preview')}}</h4>
                                    <div c>
                                        <div id="my_camera"></div>
                                    </div>
                                    <input type="button" class="btn mt-1 btn-flat btn-success" value="Take Snapshot"
                                        onClick="takeSnapshot();">
                                </div>
                                <div class="col-sm-5">
                                    <h4>{{__('Image Taken')}}</h4>
                                    <div id="results">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" onclick="cancelSnap();"
                                data-dismiss="modal">{{__('Cancel')}}</button>
                            <button id="save_btn" type="button" disabled class="btn btn-primary" data-dismiss="modal"
                                onclick="saveSnap();">{{__('Save Changes')}}</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </div>
    </div>
    <div class="col-md-1"></div>
</div>

@endsection
