<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- bootstrap link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <title>Sign up</title>
</head>
<body>
    <!-- bootstrap signup page -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Sign up</h3>
                    </div>
                    <!-- validation error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif    
                    <div class="card-body">
                        <form action="/signupAction" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
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
                        

                            @if(config('services.recaptcha.key'))
                                <div class="g-recaptcha"
                                    data-sitekey="{{config('services.recaptcha.key')}}">
                                </div>
                            @endif 



                                <div class="form-group" id="activity_name">
                                    
                                </div>
                                
                             

                            <div class="form-group">
                                <button class="btn btn-primary btn-block">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- bootstrap js -->
    <!-- GOOGLE RECAPCTHA SCRIPT -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
           $('#activity').change(function(){
               var activity = $(this).val();
               $('#activity_name').html("");
                  for(var i=0;i<10;i++){
                    $response=fetch("http://www.boredapi.com/api/activity?type="+activity);
                        $response.then(function(response){
                            return response.json();
                        }).then(function(data){
                            console.log(data);
                           
                             $('#activity_name').append('<input name="activity_name[]" class="form-control" value="'+data.activity+'">');

                            
                        });
                    }

            });   
        });
    </script>
</body>
</html>