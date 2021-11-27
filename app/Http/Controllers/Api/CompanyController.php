<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\EvaluationService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $repository;
    protected $evaluationService;

    public function __construct(Company $repository, EvaluationService $evaluationService)
    {
        $this->repository = $repository;
        $this->evaluationService = $evaluationService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = $this->repository->getCompanies($request->get('filter', ''));
        return CompanyResource::collection($companies);
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
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $category = $this->repository->whereUuid($uuid)->firstOrFail();

        $evaluations = $this->evaluationService->getEvaluationsCompany($uuid);

        return (new CompanyResource($category))
                    ->additional([
                        'evaluations' => json_decode($evaluations)
                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCompanyRequest $request, $uuid)
    {
        $category = $this->repository->whereUuid($uuid)->firstOrFail();
        $category->update($request->validated());

        return response()->json(['message' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $category = $this->repository->whereUuid($uuid)->firstOrFail();

        $category->delete();

        return response()->json([], 204);
    }
}
