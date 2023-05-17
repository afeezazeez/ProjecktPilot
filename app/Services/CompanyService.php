<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\ICompanyRepository;
use App\Interfaces\IUserRepository;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CompanyService
{
    public function __construct(
        ICompanyRepository  $companyRepository,
        FileService         $fileService,
        IUserRepository     $userRepository
    ) {
        $this->companyRepository  = $companyRepository;
        $this->fileService        = $fileService;
        $this->userRepository     = $userRepository;
    }

    /**
     * Refresh access token
     * @param array $data
     * @return Company
     * @throws ClientErrorException
     */
    public function createCompany(array $data): Company
    {
        DB::beginTransaction();

        try {

            $logo = $this->fileService->uploadCompanyLogo($data['logo']);

            $companyData = [
                'name'          => $data['name'],
                'description'   => $data['description'],
                'logo'          => $logo
            ];

            $company =  $this->companyRepository->create($companyData);

            $this->userRepository->attachCompany(auth()->user(),$company->id);

            DB::commit();

            return $company;

        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            throw new ClientErrorException(__('validation.error_occurred'));
        }

    }



}
