@extends('admin.master')
@section('body')
            <section class="pt-3">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Edit</h3>
                    </div>


                    <form action="{{route('blog-post.update',$blog_post->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                {{-- blog category  --}}
                                @foreach($blog_categories as $blog_category)
                                <div class="col-md-4">
                                    {{-- @php
                                        dd($blog_category->blogCategoryPosts);
                                    @endphp --}}
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="checkbox">
                                                <label>
                                                    <input data-id="{{ $blog_category->id }}" type="checkbox" class="mr-2 pt-2" name="blog_category_ids[]" value="{{$blog_category->id}}"
                                                    @foreach ($blog_category->blogCategoryPosts as $blogCategoryPost)
                                                        {{$blogCategoryPost->hasBlogPost($blog_post->id)?'checked':''}}
                                                    @endforeach
                                                    {{-- {{$blog_category->blogCategoryPosts->hasBlogPost($blog_post->id)?'checked':''}} --}}
                                                    >{{$blog_category->name}}</label>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            @if($blog_category->blogSubcategories)
                                                <div class="pl-3">
                                                    @foreach($blog_category->blogSubcategories as $blog_Subcategory)
                                                        <div class="checkbox">
                                                            <label><input data-category-id="{{ $blog_category->id }}" type="checkbox" class="mr-2" name="blog_subcategory_ids[]" value="{{$blog_Subcategory->id}}"
                                                                @foreach ($blog_Subcategory->blogSubcategoryPosts as $blogSubcategoryPost)
                                                                {{$blogSubcategoryPost->hasBlogPost($blog_post->id)?'checked':''}}
                                                            @endforeach

                                                                >{{$blog_Subcategory->name}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            @endif
                                        </div>
                                    </div>
                            </div>
                            @endforeach

                                {{-- blog category end --}}
                                <label for="">Title</label>
                                <input type="text" name="title" value="{{$blog_post->title}}" class="form-control" placeholder="Enter Title">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" id="summernote" class="form-control" rows="5">{{$blog_post->description}}</textarea>
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Excerpt</label>
                                <input type="text" name="excerpt" class="form-control" value="{{$blog_post->excerpt}}" placeholder="Enter post excerpt">
                                @error('excerpt')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Tags(For Search)</label>
                                <input type="text" name="tags" class="form-control" value="{{$blog_post->tags}}" placeholder="Ex: cricket, football, wedding etc">
                                @error('tags')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option>--Select--</option>
                                    <option value="pending" {{$blog_post->status=='pending'?'selected':''}}>Pending</option>
                                    <option value="draft" {{$blog_post->status=='draft'?'selected':''}}>Draft</option>
                                    <option value="published" {{$blog_post->status=='published'?'selected':''}}>Published</option>
                                </select>
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (! $blog_post->feature_image)
                            <div class="form-group">
                                <label for="">Feature Image</label>
                                <input type="file" name="feature_image" class="form-control-file mb-2" value="{{$blog_post->feature_image}}" >
                                <img src="{{asset('img/'.'fi.jpg')}}" alt="{{$blog_post->id}}" width="350">
                            </div>
                            @else
                            <div class="form-group">
                                <label for="">Feature Image</label>
                                <input type="file" name="feature_image" class="form-control-file mb-2" value="{{$blog_post->feature_image}}" >
                                <img src="{{asset($blog_post->feature_image)}}" alt="{{$blog_post->id}}" width="350">
                            </div>

                            @endif
                                {{-- <div class="form-group">
                                    <label for="">Feature Image</label>
                                    <input type="file" name="feature_image" class="form-control-file mb-2" value="{{$blog_post->feature_image}}" >
                                    <img src="{{asset($blog_post->feature_image)}}" alt="{{$blog_post->id}}" width="350">
                                </div> --}}


                            <input type="number" name="editedby_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}" hidden>
                        </div>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" value="update">
                        </div>
                    </form>
                </div>

            </section>
@endsection


@section('script')
<script>
    $(document).ready(function(){
     $('[data-category-id]').on('change',function(){
        console.clear();
        if(this.checked){
            $('[data-id=' + $(this).data('category-id') + ']').prop('checked',true);
        }
     });
    });

</script>
@endsection
