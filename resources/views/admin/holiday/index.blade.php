@extends('admin.master')
@section('body')
    <section class="content py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Holiday</h3>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="20">SL NO</th>
                                    <th width="100">Action</th>
                                    <th>Date</th>
                                    <th>Year</th>
                                    <th>Purpose</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($holidays as $holiday)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a href="{{route('holiday.show',$holiday->id)}}" class="btn btn-xs btn-outline-info mr-1 float-left"><i class="fa fa-eye"></i></a>
                                            <a href="{{route('holiday.edit',$holiday->id)}}" class="btn btn-xs btn-outline-primary mr-1 float-left"><i class="fa fa-edit"></i></a>

                                            <form action="{{route('holiday.destroy',$holiday->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-xs btn-outline-danger mr-1 float-left"><i class="fa fa-trash"></i></button>

                                            </form>
                                        </td>
                                        <td>{{$holiday->date}}</td>
                                        <td>{{$holiday->year}}</td>
                                        <td>{{$holiday->purpose}}</td>

                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection

{{--@section('script')--}}
{{--    <script>--}}
{{--        $('input[name=toogle]').change(function(){--}}
{{--            var mode=$(this).prop('checked');--}}
{{--            var id=$(this).val()--}}
{{--            $.ajax({--}}
{{--                url:"{{route('company.status')}}",--}}
{{--                type:"POST",--}}
{{--                data:{--}}
{{--                    _token:'{{csrf_token()}}',--}}
{{--                    mode:mode,--}}
{{--                    id:id,--}}
{{--                },--}}
{{--                success:function(response){--}}
{{--                    if(response.status){--}}
{{--                        alert(response.msg);--}}
{{--                    }--}}
{{--                    else{--}}
{{--                        alert('please try again');--}}
{{--                    }--}}
{{--                }--}}
{{--            })--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}

