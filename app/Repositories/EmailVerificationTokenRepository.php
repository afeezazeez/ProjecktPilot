<?php

namespace App\Repositories;

use App\Interfaces\IEmailVerificationTokenRepository;
use App\Models\EmailVerificationToken;

class EmailVerificationTokenRepository implements IEmailVerificationTokenRepository
{

    protected EmailVerificationToken $model;

    public function __construct(EmailVerificationToken $model)
    {
        $this->model = $model;
    }


    /**
     * Create email verification token for user
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Create fetch email verification token record using the token
     */
    public function findByToken(string $token)
    {
        return $this->model->where('token',$token)->first();
    }

    /**
     * Delete user token
     */
    public function delete(EmailVerificationToken $token)
    {
        return $token->delete();
    }



}
