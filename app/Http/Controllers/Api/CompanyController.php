<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $repository;

    public function __construct(Company $repository)
    {
        $this->repository = $repository;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->repository->with('category')->paginate();
        return CompanyResource::collection($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCompanyRequest $request)
    {
        $category = $this->repository->create($request->validated());

        return new CompanyResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $category = $this->repository->whereUrl($url)->firstOrFail();

        return new CompanyResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $url)
    {
        $category = $this->repository->whereUrl($url)->firstOrFail();

        $category->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy($url)
    {
        $category = $this->repository->whereUrl($url)->firstOrFail();

        $category->delete();

        return response()->json([], 204);
    }
}
