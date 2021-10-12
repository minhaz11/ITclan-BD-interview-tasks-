<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Idea Tournament</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container" id="app">
            @if (!session('tournament'))
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8">
                        <h2 class="my-4">IDEA TOURNAMENT</h2>
                        <form action="{{route('idea.store')}}" method="POST">
                            @csrf
                                <div class="form-group mb-2">
                                    <label for="name">Name</label>
                                    <input id="name" class="form-control" type="text" name="name" required value="{{old('name')}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="email">Email</label>
                                    <input id="email" class="form-control" type="text" name="email" required value="{{old('email')}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="idea">Idea</label>
                                    <input id="idea" class="form-control" type="text" name="idea" required value="{{old('idea')}}">
                                </div>

                                <div class="form-group text-end">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                        </form>
                    </div>
                </div>
            @endif
            <hr>

            <div class="row justify-content-center mt-5 mb-5" id="winner-box">
                <div class="col-md-10 text-center">
                    @if (!session('tournament') && $perticipants->count() < 8)
                       <h6><span class="text-primary">{{8 - $perticipants->count()}}</span> Perticipants remaining for start the tournaments</h6>
                    @else
                      <div class="d-flex justify-content-between mb-3">
                        @if ( $perticipants->count() == 1) 
                          <h6>Next tournament is starting soon</h6>
                            <a href="{{route('new.tournament')}}" class="btn btn-primary btn-sm">New Tournament</a>
                        @else
                            <h6>Current perticipants of the tournament</h6>
                            <h5 id="timer">Time : 0m 0s</h5>
                        @endif
                       
                        
                      </div>

                      <table class="table table-light table-striped" >
                          <thead class="thead-light">
                              <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Idea</th>
                                  <th>Wining Status</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($perticipants as $user)
                              <tr>
                                  <td>{{$user->name}}</td>
                                  <td>{{$user->email}}</td>
                                  <td>{{$user->idea}}</td>
                                  <td>
                                      @if ( $perticipants->count() < 8)
                                          <span class="badge bg-success">Winner</span>
                                       @else
                                           <span class="badge bg-warning">Pending</span>
                                      @endif
                                      
                                  </td>
                              </tr>  
                              @endforeach
                          </tbody>
                      </table>
                    @endif
                    
                </div>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @include('alerts.error')
        @include('alerts.errors')
        @include('alerts.success')

        @if(session('tournament') && $perticipants->count() != 1)
            <script>
                var duration = 1
                var countDownDate = new Date();
                countDownDate.setMinutes(countDownDate.getMinutes() + parseInt(duration));
                var x = setInterval(function () {  
                    var now = new Date().getTime();  
                    var distance = countDownDate - now; 
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000); 
                    document.getElementById("timer").innerHTML = 'Timer : '+ minutes + "m " + seconds + "s "; 
    
                    if (distance < 0) {
                        document.getElementById("timer").innerHTML = '0m 0s'
                        clearInterval(x);
                        var data = {
                            _token:'{{csrf_token()}}'
                        }
                        $.post('{{route('elimination')}}',data).done(function (res) { 
                            location.reload()
                        })
                    }
                }, 1000);
            </script>
        @endif
    </body>
</html>
