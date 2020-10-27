@extends('admin_layout')
@section('content')

<div class="content-wrapper">

<!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
             Message Brockering Framework
        <small>(HL7 Integration Prototype)</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
   
            <div class="box box-info">
            
              <div class="box-header with-border">
      <!--h3 class="box-title"> Institute Registration</h3-->
            </div>
                        {{csrf_field() }}

            <!-- /.box-header -->
            <h3>No of new patient Registration : <?=count($msgs)?></h3> 


              <section class="content">
            <div class="box box-primary">
              <div class="box-header with-border">
           @if($errors->any())
           @if($errors->first()=="Server Not Accepting")
              <h4><font color="red">{{$errors->first()}}</font></h4>
          @else
              <h4><font color="green">{{$errors->first()}}</font></h4>
          @endif
          @endif
              </div>
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row"><div class="col-sm-12"><table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 95px;">Name</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 126px;">NIC</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 116px;">village</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 80px;">DOB</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 80px;">Generate</th>
                <!--<th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 80px;">Venue</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 57px;"></th></tr>-->
                </thead>
                <tbody>
                  <?php foreach ($msgs as $msg) : ?>
                 <tr>

                  <td><?= $msg->Name ?> </td>
                
                  <td><?= $msg->NIC ?></td>
                 
                  <td><?= $msg->village ?></td>
                    
                  <td><?= $msg->DOB ?></td>

                  <td>
                    <a href='{{$msg->id}}/generateAA01'><input type="Button" value="Generate" action=></a>
                  </td>
              
                </tr>

                <?php endforeach; ?>
            
                </tbody>
              </table>
              </div>
              </div>
            </div>
    </div>

    </div>
    </section>
           
            <!-- form start -->
         
              </div>
              </div>
              <!-- /.bo
            
   
    </section>
    <!-- /.content -->


@endsection()
@section('page_specific_scripts')

    <!-- DataTables -->
    <script src="AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="AdminLTE//plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script> 
        $(document).ready(function(){
        $('#example1').DataTable();
});
</script>
@endsection()