<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogSubCategory;
use App\Models\BlogSubcategoryPost;
use App\Models\BlogCategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        menuSubmenu('blog_posts', 'allBlogPosts');
        return view('admin.blog-post.index', ['blog_posts' => BlogPost::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function blogPostActive(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('blog_posts')->where('id', $request->id)->update(['active' => 1]);
        } else {
            DB::table('blog_posts')->where('id', $request->id)->update(['active' => 0]);
        }
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    public function create()
    {

        $blogcategory = BlogCategory::all();
        $blogsubcategory = BlogSubCategory::all();

        menuSubmenu('blog_posts', 'createBlogPost');
        return view('admin.blog-post.create', compact(['blogcategory', 'blogsubcategory']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'feature_image' => 'nullable|image|mimes:jpeg,webp,jpg,png',
        ]);

        $post = BlogPost::createBlogPost($request);

        if ($request->subcategories) {
            foreach ($request->subcategories as $subcat) {
                $subcat = BlogSubCategory::where('id', $subcat)->first();

                if ($subcat) {
                    $subcatPost = new BlogSubcategoryPost;
                    $subcatPost->blog_post_id = $post->id;
                    $subcatPost->blog_subcategory_id = $subcat->id;
                    $subcatPost->save();

                    $catPost = BlogCategoryPost::where('blog_post_id', $post->id)
                        ->where('blog_category_id', $subcat->blog_category_id)
                        ->first();

                    if (!$catPost) {
                        $subcatPost = new BlogCategoryPost;
                        $subcatPost->blog_post_id = $post->id;
                        $subcatPost->blog_category_id = $subcat->blog_category_id;
                        $subcatPost->save();
                    }
                }
            }
        }



        if ($request->categories) {
            foreach ($request->categories as $cat) {
                $cat = BlogCategory::where('id', $cat)->first();
                if ($cat) {
                    $catPost = BlogCategoryPost::where('blog_post_id', $post->id)
                        ->where('blog_category_id', $cat->id)
                        ->first();

                    if (!$catPost) {
                        $subcatPost = new BlogCategoryPost;
                        $subcatPost->blog_post_id = $post->id;
                        $subcatPost->blog_category_id = $cat->id;
                        $subcatPost->save();
                    }
                }
            }
        }

        menuSubmenu('blog_posts', 'createBlogPost');
        return redirect()->route('blog-post.create')->with('success', 'Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        menuSubmenu('blog_posts', 'allBlogPosts');
        return view('admin.blog-post.view', ['blog_post' => BlogPost::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //    $blogcategories=BlogCategory::where('active',1)->get();
        //    $blogsubcategory=BlogSubcategoryPost::all();
        //    $blogcategory=BlogCategory::all();
        //    $blogsubcategory=BlogSubCategory::all();
        menuSubmenu('blog_posts', 'allBlogPosts');
        return view('admin.blog-post.edit', ([
            'blog_post' => BlogPost::find($id), 'blog_categories' => BlogCategory::Where('active', 1)->get(),
            'blog_posts' => BlogPost::all()
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogPost $blogPost)
    {

        $this->validate($request, [
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'status' => 'required',
            'feature_image' => 'nullable|image|mimes:jpeg,webp,jpg,png',

        ]);

        $blogNewCategories = collect($request->input('blog_category_ids'));
        $blogNewSubcategories = collect($request->input('blog_subcategory_ids'));

        $blogOldCategories = $blogPost->blogCategoryPosts()->pluck('id');
        $blogOldSubCategories = $blogPost->blogSubCategoryPosts()->pluck('id');

        $categoriesToDelete = $blogOldCategories->diff($blogNewCategories);
        $subcategoriesToDelete = $blogOldSubCategories->diff($blogNewSubcategories);

        $categoriesToCreate = $blogNewCategories->diff($blogOldCategories);
        $subcategoriesToCreate = $blogNewSubcategories->diff($blogOldSubCategories);

    //    $blog=BlogSubCategory::find($subcategoriesToCreate)->with('blogCategory.id');

    // dd($blog);

        $blogPost->blogCategoryPosts()->createMany(
                $categoriesToCreate->map(function ($value, $key) use ($blogPost) {
                    return [
                        'blog_post_id' => $blogPost->id,
                        'blog_category_id' => $value,
                    ];
                })->toArray()
        );

        $blogPost->blogSubCategoryPosts()->createMany(

                $subcategoriesToCreate->map(function ($value, $key) use ($blogPost) {
                    return [
                        'blog_post_id' => $blogPost->id,
                        'blog_subcategory_id' => $value,
                    ];
                })->toArray()

        );

        BlogCategoryPost::destroy($categoriesToDelete);
        BlogSubcategoryPost::destroy($subcategoriesToDelete);

        BlogPost::updateBlogPost($request, $blogPost->id);
        menuSubmenu('blog_posts', 'allBlogPosts');
        return redirect()->route('blog-post.index')->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogPost::deleteBlogPost($id);
        menuSubmenu('blog_posts', 'allBlogPosts');
        return redirect()->route('blog-post.index')->with('success', 'Successfully Deleted');
    }
}
