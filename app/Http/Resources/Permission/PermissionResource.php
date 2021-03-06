<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'permission_level' => $this->permission_level,
            'permission_name' => $this->ph_label,
            'labels' => $this->whenLoaded('permissions', function () {
                return $this->permissions;
            })
        ];
    }
}
