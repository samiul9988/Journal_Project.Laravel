@extends('admin.master')
@section('body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">   Membership Details</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item font-weight-bold">Name:{{ $memberdetails->name }}</li>
                    <li class="list-group-item font-weight-bold">Mobile:{{ $memberdetails->mobile }}</li>
                    <li class="list-group-item font-weight-bold">Email:{{ $memberdetails->email }}</li>
                    <li class="list-group-item font-weight-bold">Company:{{ $memberdetails->company }}</li>
                    <li class="list-group-item font-weight-bold">Profession:{{ $memberdetails->profession }}</li>
                    <li class="list-group-item font-weight-bold">Designation{{ $memberdetails->designation }}</li>
                    <li class="list-group-item font-weight-bold">Gender:{{ $memberdetails->gender }}</li>
                    <li class="list-group-item font-weight-bold">Date of birth:{{ $memberdetails->dob }}</li>
                  </ul>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-body">
            @if (!$memberdetails->user_id)
            <a href="{{ route('createuser',$memberdetails->id) }}">Create Member</a>

            @else
            <p class="font-weight-bold">User Id :{{ $memberdetails->user->id }}</p>
            <p class="font-weight-bold">Member Id:{{ $memberdetails->id }}</p>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection
