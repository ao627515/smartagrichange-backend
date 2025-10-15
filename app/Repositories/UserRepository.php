<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $model;
    private $roleRepository;
    public function __construct(User $model, RoleRepository $roleRepository)
    {
        parent::__construct($model);
        $this->model = $model;
        $this->roleRepository = $roleRepository;
    }

    public function isPhoneNumberVerified($phoneNumber, $callingCode)
    {
        $user = $this->model->where('phone_number', $phoneNumber)
            ->whereHas('countryCallingCode', function ($query) use ($callingCode) {
                $query->where('calling_code', $callingCode);
            })->first();

        return $user->phone_number_verified_at ? true : false;
    }

    public function phoneNumberExists($phoneNumber, $callingCode)
    {
        $user = $this->model->where('phone_number', $phoneNumber)
            ->whereHas('countryCallingCode', function ($query) use ($callingCode) {
                $query->where('calling_code', $callingCode);
            })->first();

        return $user ? true : false;
    }



    public function phoneNumberExistsAndNotVerified($phoneNumber, $callingCode)
    {
        $user = $this->model->where('phone_number', $phoneNumber)
            ->whereHas('countryCallingCode', function ($query) use ($callingCode) {
                $query->where('calling_code', $callingCode);
            })->first();

        if ($user && is_null($user->phone_number_verified_at)) {
            return true;
        }

        return false;
    }


    public function findUserByPhoneNumberAndCallingCode($phoneNumber, $callingCode, $columns = ['*'])
    {
        return $this->model->where('phone_number', $phoneNumber)
            ->whereHas('countryCallingCode', function ($query) use ($callingCode) {
                $query->where('calling_code', $callingCode);
            })->first($columns);
    }
}
