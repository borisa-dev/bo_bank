<?php

namespace App\Http\Resources;

use App\Interfaces\Repositories\IAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'          => $this->name,
            'email'         => $this->email,
            'date_of_birth' => Carbon::create($this->date_of_birth)->toFormattedDateString(),
            'age'           => Carbon::parse($this->date_of_birth)->age,
            'accounts'      => AccountResource::collection($this->whenLoaded('accounts')),
            'balance'       => $this->balance,
        ];
    }
}
