<?php

namespace App\Http\Requests\Permission;

use App\Enums\PermissionRoleEnum;
use App\Http\Requests\Core\AuthorizationAdminRequest;
use App\Models\PermissionHierarchy;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StorePermissionRequest extends AuthorizationAdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rol' => [new Enum(PermissionRoleEnum::class), Rule::exists(PermissionHierarchy::class, 'permission_level')],
            'label' => 'unique:App\Models\PermissionDetail,pd_label',
            'description' => ['required', 'string']
        ];
    }
}
