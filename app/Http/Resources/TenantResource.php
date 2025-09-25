<?php

namespace App\Http\Resources;

use App\Enums\RoleName;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (empty($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'can.update' => in_array($this->pivot->tenant_role, [RoleName::TENANT_ADMIN->value, RoleName::TENANT_MEMBER->value]),
            'can.delete' => $this->pivot->tenant_role == RoleName::TENANT_ADMIN->value,
        ];
    }
}
