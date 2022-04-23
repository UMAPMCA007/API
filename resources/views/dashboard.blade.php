@extends('layout.app')
@section('content')
<div class="col-md-6 offset-md-2 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Dashboard</h4>
                        </div>
                        <div class="card-body">
                            <h4>Welcome {{Session::get('user')->name}}</h4>
                            <p>You are logged in!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
@endsection