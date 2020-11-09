@extends('template.main')

@section('title', $title)

@section('content_title',"Pharamacy")
@section('content_description',"Issue Medicines here.")
@section('breadcrumbs')

<ol class="breadcrumb">
    <li><a href="{{route('dash')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
    <li class="active">Here</li>
</ol>
@endsection

@section('main_content')

<section class="content">

    <div class="box">


        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Appointment ID</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($prchi as $pre)
                                <tr>
                                    <td>{{$pre->patient_id}}</td>
                                    <td class="text-capitalize">{{$pre->patient_name}}</td>
                                    <td class="text-capitalize">{{$pre->doctor_name}}</td>
                                    <td>{{$pre->appointment_id}}</td>
                                    <td class='text-uppercase text-bold {{($pre->medicine_issued == "NO")? "text-danger": "text-success"}}'>{{$pre->medicine_issued}}</td>
                                    <td>
                                        <a href="{{url('issue').'/'.$pre->id}}"><i class="fa fa-eye" style="color: black"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Appointment ID</th>
                                <th>Status</th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- print priview --}}
            {{-- <div class="col-md-3">
                <form action="{{route('all_print_preview')}}" method="get">
                    {{csrf_field()}}
                    <button type="submit" class="btnprn btn btn-danger">Print Preview</button>
                    <input type="text" name="start" value="" style="display:none">
                    <input type="text" name="end" value="" style="display:none">
                    <input type="text" name="type" value="" style="display:none">
                </form>
            </div> --}}
        </div>
</section>

<script>
    $(function () {
        $('#example1').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })

    // $(document).ready(function () {
    //     $('.btnprn').printPage();
    // });
</script>
@endsection