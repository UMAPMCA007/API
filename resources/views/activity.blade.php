@extends('layout.app')
@section('content')
<div class="container">
    <!-- warning message from javascript -->
<div class="col-md-6 offset-md-2" id="alert">            
</div>  
<!-- bootstrap model -->
<div class="modal  " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:hidden">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <input type="hidden" name="id" value="" id="id">
                        <div class="form-group">
                            <label for="activity_type">Activity Type</label>
                            <input type="text" class="form-control" id="activity_type" name="activity_type" placeholder="Activity Type">
                        </div>
                        <div class="form-group">
                            <label for="activity_name">Activity Name</label>
                            <input type="text" class="form-control" id="activity_name" name="activity_name" placeholder="Activity Name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button  id="save_model" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>


 @if(Session::get('user')->IsAdmin!='1')
<button type="button" class="btn btn-primary col-md-2 offset-md-8" data-toggle="modal" data-target="#exampleModal3">
  Add Activity
</button>
@endif
<!-- Modal -->

<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            @csrf
            <input type="hidden" name="id" value="{{Session::get('user')->id}}" id="id_add">
            <div class="form-group">
                <label for="Activity">Activity Type</label>
                    <select type="text" name="activity_type" id="activity"  class="form-control">
                        <option disabled selected >Select Option</option>
                         <option value="education">Education</option>
                         <option value="recreational">Recreational</option>
                         <option value="social">Social</option>
                         <option value="diy">Diy</option>
                         <option value="charity">Charity</option>
                         <option value="cooking">Cooking</option>
                         <option value="relaxation">Relaxation</option>
                         <option value="music">Music</option>
                         <option value="busywork">Busywork</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="activity_name" >Activity Name</label>
                <input type="text" class="form-control" id="activity_name_add" name="activity_name" value="" placeholder="Activity Name">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="add" class="btn btn-primary">Add</button>
      </div>
    </div>
  </div>
</div>
<!-- bootstrap model -->
    <div class="row">        
       <div class="col-md-8 offset-md-2 mb-5">
        <div class="card mt-3">
         <div class="card-header">
            <h4>Activities</h4>
          </div>
          <div class="card-body">
          <!-- button to connect model2 -->
            <table class="table table-bordered table-striped" id="table1" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Activity Type</th>
                        <th>Activity Name</th>
                        <th>action</th>
                    
                    </tr>
                </thead>
                <tbody >
                    @foreach($activities as $activity)
                    
                    <tr>
                        <td>{{$activity->id}}</td>
                        <td>{{$activity->activity_type}}</td>
                        <td>{{$activity->activity_name}}</td>
                        <td>
                            @if(Session::get('user')->IsAdmin == "1")
                                <!-- delete button -->
                            <button type="button" class="btn btn-danger delete" id="{{$activity->id}}">Delete</button>   
                            @else
                             <button type="button" class="btn btn-primary edit"  id="{{$activity->id}}">Edit</button>
                            @endif
                        </td>
                    </tr>
                   
                    @endforeach
                </tbody>
            </table>
            {{$activities->links('pagination::bootstrap-4')}} 
            </ul> 
         </div>  
       </div>  
    </div> 
    
@endsection
@section('script')
<!-- jquery -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
<script src = "https://code.jquery.com/jquery-3.5.1.js"> </script> 
<script src = "https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"> </script> 
<script>
 $(document).ready(function(){
     load ();  
  function load(){

     $('#table').html("");
        
  } 

        $('.edit').click(function(){
            var id = $(this).attr('id');
            $.ajax({
                url:'/activity/'+id,
                type:'GET',
                dataType:'json',
                success:function(data){
                    $('#id').val(data.id);
                    $('#activity_type').val(data.activity_type);
                    $('#activity_name').val(data.activity_name);
                    $('#exampleModal').show();
                    
                }
            });

        });
        
                    
       $('#save_model').click(function(){
            var id = $('#id').val();
            var activity_type = $('#activity_type').val();
            var activity_name = $('#activity_name').val();
            $.ajax({
                url:'/activity_save/'+id,
                type:'PUT',
                data:{
                    '_token':'{{csrf_token()}}',
                    'activity_type':activity_type,
                    'activity_name':activity_name
                },
                dataType:'json',
                success:function(data){
                    $('#exampleModal').hide();
                    location.reload();
                }
            });
            load();
        });

        // fetch  activity
        $('#activity').change(function(){
            var activity = $(this).val();
            $.ajax({
                url:'/activity_fetch/'+activity,
                type:'GET',
                dataType:'json',
                success:function(data){
                    console.log(data.activity);
                    $('#activity_name_add').val(data.activity);
                }
            });
        });

        // save activity
        $('#add').click(function(){
            var activity_type = $('#activity').val();
            var activity_name = $('#activity_name_add').val();
            var id = $('#id_add').val();
            $.ajax({
                url:'/activity_add/'+id,
                type:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    'activity_type':activity_type,
                    'activity_name':activity_name
                },
                dataType:'json',
                success:function(data){
                    console.log(data);
                    if(data.success){
                        $('#alert').append('<div class="alert alert-success">'+data.success+'</div>');
                    }else{
                        $('#alert').append('<div class="alert alert-danger">'+data.error+'</div>');
                    }
                    $('#exampleModal3').hide();
                    location.reload();
                     
                }
            });
        });
        // delete activity
        $('.delete').click(function(){
            var id = $(this).attr('id');
            $.ajax({
                url:'/activity_delete/'+id,
                type:'DELETE',
                data:{
                    '_token':'{{csrf_token()}}',
                },
                dataType:'json',
                success:function(data){
                    console.log(data);
                    location.reload();
                }
            });
        });

    });

</script>
@endsection