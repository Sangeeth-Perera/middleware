@extends('admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
Request Health Care Information
        <small>(Health care)</small>
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
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="/hl7Request" files="true" enctype="multipart/form-data">
            
            {{csrf_field() }}

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
 
             <div class="box-body">
               <div class="row">
              <div class="col-md-6">
              <div class="box box-primary">
            <div class="box-header with-border">
              
              <label>General Details</label><br><br>
               <div class="form-group">
                  <label for="instituteName" class="col-sm-2 control-label" >NIC</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="instituteName" name="name" placeholder="" required>
                  </div>
                  </div>
               
                <div class="form-group">
                <label for="type" class="col-sm-2 control-label">Name</label>
               <div class="col-sm-10">
        
                    <input type="text" class="form-control" id="instituteContactNo" name="contactNo" placeholder="" required>

                </div>
                </div>
                <div class="form-group">
                  <label for="inputPicture" class="col-sm-2 control-label">HIN</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="instituteContactNo" name="contactNo" placeholder="" required>
                 </div>
                </div>
                </div>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="box box-primary">
            <div class="box-header with-border">
                <label>Required Details</label><br><br>
              
                 <div class="form-group">
                  <label for="inputContact" class="col-sm-2 control-label"> Detail 1</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="instituteContactNo" name="contactNo" placeholder="" required>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="inputemail" class="col-sm-2 control-label"> Detail 2 </label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="instituteEmail" name="email" placeholder="">
                  </div>
                  </div>
              
               <div class="form-group">
                  <label for="inputAddress" class="col-sm-2 control-label"> Detail 3</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="instituteAddress" name="address" placeholder="">
                  </div>
                  </div>
                  </div>
                </div>
                </div>
                </div>
                  <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Request</button>
                </div>
                
                </form>
              </div>
              </div>
              <!-- /.bo -- >
            
   

    </section>
    <!-- /.content -->
</div>
@endsection()

@section('page_specific_scripts')
<script>
document.getElementById("image").onchange = function () {
    var reader = new FileReader();
    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("image").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};
   function getteamName(selectObject)
            {
                document.getElementById("teamId").value=selectObject.value;
            };
          
</script>
<script type="text/javascript">
         
        </script>
@endsection()