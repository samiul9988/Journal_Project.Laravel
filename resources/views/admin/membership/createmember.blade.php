@extends('admin.master')
@section('body')

<section>

    <div class="row">
        <div class="col-12">
            <div class="card mt-1">
                <div class="card-header">
                    <h3 class="card-title"> <i class="fas fa-edit"></i> New Membership application</h3>
                </div>
               <div class="card-body bg-gray-light">

                <div class="card">
                    <div class="card-body ">

                        <form action="{{ route('membership') }}" method="POST" class="form-group">
                            {{ csrf_field() }}
                            <input type="text" name="name"  placeholder="Enter your Name" class="form-control"><br>
                            <input type="text" name="mobile" placeholder="Enter mobile" class="form-control"><br>
                            <input type="email" name="email" placeholder="Enter your email" class="form-control"><br>
                            <input type="text" name="living_country" placeholder="Enter your living country" class="form-control"><br>
                            <input type="text" name="company" placeholder="Enter your company name" class="form-control"><br>
                            <input type="text" name="profession" placeholder="Enter your profession" class="form-control"><br>
                            <input type="text" name="designation" placeholder="Enter your designation" class="form-control"><br>
                            <select class="form-select" name="gender" aria-label="Default select example">
                                <option selected>select Your gender</option>
                                <option value="male">male</option>
                                <option value="female">female</option>
                                <option value="others">others</option>
                              </select><br><br>
                              <label for="date">Select your date of birth</label>
                            <input type="date" id="date" name="dob"  class="form-control"><br>


                            <input type="submit" name="submit" value="save" class="btn btn-block btn-success"><br>
                        </form>

                    </div>
                </div>

               </div>
            </div>

            @include('errors')


        </div>
    </div>

</section>

@endsection
