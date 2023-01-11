@extends('admin.master')
@section('body')
  <div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">  All Membership applications</h3>
            </div>
            <div class="card-body" style="font-size: 12px">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <th>Sl no</th>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>designation</th>
                        <th>profession</th>
                        <th>Living_country</th>
                        <th>Gender</th>
                        <th>Dob</th>
                        <th>address</th>
                        <th>Status</th>


                    </thead>
                    <tbody>
                        @foreach ($allmembers as $allmembers)
                        <tr>
                            <td>{{ $allmembers->id }}</td>
                            <td><div class="dropdown show">
                                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Action
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <a class="dropdown-item" href="{{ route('details',$allmembers->id) }}">Details</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-edit"></i>edit</a>
                                  <a class="dropdown-item" href="#">Delete</a>

                                </div>
                              </div></td>
                            <td>{{ $allmembers->name }}</td>
                            <td>{{ $allmembers->mobile }}</td>
                            <td>{{ $allmembers->email  }}</td>
                            <td>{{ $allmembers->company }}</td>
                            <td>{{ $allmembers->designation }}</td>
                            <td>{{ $allmembers->profession }}</td>
                            <td>{{ $allmembers->living_country }}</td>
                            <td>{{ $allmembers->gender }}</td>
                            <td>{{ \carbon\carbon::create($allmembers->dob)->format('d-m-y') }}</td>
                            <td>{{ $allmembers->address }}</td>
                            <td>{{ $allmembers->status }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>


    </div>

  </div>
@endsection
