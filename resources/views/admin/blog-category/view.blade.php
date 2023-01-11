@extends('admin.master')
@section('body')
    <section class="pt-5">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{$blog_category->name}} Details</h3>
            </div>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Journal Category ID</th>
                    <td>{{$blog_category->id}}</td>
                </tr>
                <tr>
                    <th>Journal Category Name</th>
                    <td>{{$blog_category->name}}</td>
                </tr>
                <tr>
                    <th>Active</th>
                    <td>{{$blog_category->active==1?'On':'Off'}}</td>
                </tr>

            </table>
        </div>
    </section>
@endsection

