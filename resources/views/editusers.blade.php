<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laravel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
      
      .row {
        background-color: #eee;
      }
      h2 {
        background-color: #333;
        color: #fff;
      }
      .fa{
        font-size: 20px;
        padding: 3px;
      }

  </style>
</head>
<body>

<div class="container">
  <h2 class="text-center">Edit User Form</h2>
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="flash-message">
          @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
            <a href="#" class="close" data-dismiss="alert" area-label="close">x</a>
            </p>
            @endif
          @endforeach
        </div>

  <form action="{{url('/update-users')}}" method="POST" enctype="multipart/form-data">
    <!--{{csrf_field()}}-->
    @csrf
    <div class="form-group">
      <label for="email">Name:</label>
      <input type="text" class="form-control" value="{{$userdata['name']}}" placeholder="Enter name" name="name">
    </div>
    <input type="hidden" value="{{$userdata['id']}}" name="user_id">
    <div class="form-group">
      <label for="pwd">Mobile:</label>
      <input type="text" class="form-control" value="{{$userdata['mobile']}}" placeholder="Enter mobile" name="mobile">
    </div>

    <div class="form-group">
      <label for="pwd">Email:</label>
      <input type="text" class="form-control" value="{{$userdata['email']}}" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Book:</label>
      <select class="form-control" name="book[]" multiple="">
          <option value="">select</option>

          <?php
/*
          // This code run when single option selected
          <option value="book1" <?php if($userdata['books']['book']=='book1'){ echo  'selected'; } ?>>book1</option>
          <option value="book2" <?php if($userdata['books']['book']=='book2'){ echo  'selected'; } ?>>book2</option>
          <option value="book3" <?php if($userdata['books']['book']=='book3'){ echo  'selected'; } ?>>book3</option>
*/            
           // $names=[];
            foreach ($userdata['books'] as $key => $value) {
                $names[]=$value['book'];
            }  
            ?> 
          <option value="book1" <?php if($names[0]=='book1'){ echo  'selected'; } ?>>book1</option>
          <option value="book2" <?php if($names[1]=='book2'){ echo  'selected'; } ?>>book2</option>
          <option value="book3" <?php if($names[2]=='book3'){ echo  'selected'; } ?>>book3</option>

      </select>      
    </div>    
     <div class="form-group">      
      <input type="file" class="form-control" name="image">
    </div> 

     <div class="form-group">
      <label for="pwd">Iamge:</label>
      <img src="{{asset('/img/'.$userdata['image'])}}" width="100px;" height="100px" />
    </div>           

    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  </div>
  </div>
</div>
</body>
</html>
