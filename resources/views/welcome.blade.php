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
  <h2 class="text-center">User Form</h2>
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

  <form action="{{url('/userdata')}}" method="POST" enctype="multipart/form-data">
    <!--{{csrf_field()}}-->
    @csrf
    <div class="form-group">
      <label for="email">Name:</label>
      <input type="text" class="form-control" placeholder="Enter name" name="name">
    </div>
    <div class="form-group">
      <label for="pwd">Mobile:</label>
      <input type="text" class="form-control" placeholder="Enter mobile" name="mobile">
    </div>
    <div class="form-group">
      <label for="pwd">Email:</label>
      <input type="text" class="form-control" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Book:</label>
      <select class="form-control" name="book[]" multiple="">
          <option value="">select</option>
          <option value="book1">book1</option>
          <option value="book2">book2</option>
          <option value="book3">book3</option>
      </select>      
    </div>
    <div class="form-group">
      <label for="pwd">Image:</label>
      <input type="file" class="form-control" name="image">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Books</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
   
    @foreach($users as $user)
      <tr>
        <td>{{$user['name']}}</td>
        <td>{{$user['mobile']}}</td>
        <td>{{$user['email']}}</td>
        

        <td>
            <?php 
            $names=[];
            foreach ($user['books'] as $key => $value) {
                $names[]=$value['book'];
            }  
             $bookname=implode(',',$names); 

             //when single option displayed<td>{{$user['books']['book']}}</td>
            ?>             
             {{$bookname}}
        </td>           
        <td>
            @if(!empty($user['image']))
            <img src="{{asset('img/' . $user['image'])}}" height="100px;"  width="100px;" />
            @else
            <img src="{{asset('img/dummy.jpg')}}" height="100px;"  width="100px;" />
            @endif
        </td>
        <td><a href="{{url('/edit-users/'.base64_encode(convert_uuencode($user['id'])))}}"><i class="fa fa-edit"></i></a><a href="{{url('/delete-users/'.base64_encode(convert_uuencode($user['id'])))}}"><i class="fa fa-trash"></i></a></td>
      </tr>
    @endforeach
    </tbody>
  </table>  


    </div>
      
  </div>

</div>

</body>
</html>