<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'id' => $user->id,
            'ulid' => $user->ulid,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => RoleResource::collection($user->roles),
            'permissions' => PermissionResource::collection($user->getAllPermissions()),
        ];
    }
}
