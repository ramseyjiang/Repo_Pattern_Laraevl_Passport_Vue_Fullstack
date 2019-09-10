<?php

namespace Rspafs\Http\Controllers\Api;

use Illuminate\Http\Request;
use Rspafs\Http\Requests\BlogRequest;
use Rspafs\Contracts\Repositories\BlogRepositoryContract;
use Rspafs\Http\Controllers\Controller;
use Auth;

class BlogController extends Controller
{
    /**
     * @var BlogRepositoryContract
     */
    protected $blogRepo;

    /**
     * BuilderController constructor.
     */
    public function __construct(BlogRepositoryContract $blogRepo)
    {
        $this->blogRepo = $blogRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->blogRepo->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        return response()->json($this->blogRepo->createBlog($request->all(), Auth::user()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $blogId
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, string $blogId)
    {
        $blog = $this->blogRepo->getOne($blogId);

        // check if the authenticated user can match the task. The second param must be an object.
        // After add policy, it must be registered in he AuthServiceProvider.php
        $this->authorize('match', $blog);
        $this->blogRepo->updateBlog($request->all(), $blog);

        return response()->json($this->blogRepo->getOne($blogId));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $blogId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $blogId)
    {
        $blog = $this->blogRepo->getOne($blogId);

        // check if the authenticated user can match the blog. The second param must be an object.
        $this->authorize('match', $blog);  
        $blog->delete();

        return response()->json($this->blogRepo->getAll());
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $blogId
     * @return \Illuminate\Http\Response
     */
    public function show(string $blogId)
    {
        return response()->json($this->blogRepo->getOne($blogId));
    }
}
