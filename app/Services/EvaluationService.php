<?php

namespace App\Services;

use App\Services\Traits\ConsumeExternalService;

class EvaluationService
{
    use ConsumeExternalService;

    protected $token;
    protected $url;

    public function __construct()
    {
        $this->url = config('services.micro_02.url');
        $this->token = config('services.micro_02.token');
    }

    public function getEvaluationsCompany($company)
    {
        return $this->request('get', "/evaluations/{$company}");
    }
}
