<?php

namespace App\Http\Requests\Transaction;

use App\Enums\TransactionStatusEnum;
use App\Interfaces\Repositories\IAccount;
use Illuminate\Foundation\Http\FormRequest;

class SendTransactionRequest extends FormRequest
{


    public function __construct(
        public IAccount $account,
        array           $query = [],
        array           $request = [],
        array           $attributes = [],
        array           $cookies = [],
        array           $files = [],
        array           $server = [],
                        $content = null
    )
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => TransactionStatusEnum::PENDING->value,
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount'                  => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) {
                    $this->validateAmount($value, $fail);
                },
            ],
            'sender_account_number'   => 'required|string|size:32|exists:accounts,account_number',
            'receiver_account_number' => 'required|string|size:32|different:sender_account_number|exists:accounts,account_number',
        ];
    }

    protected function validateAmount($value, $fail)
    {
        try {
            $senderAccount = $this->account->fundAccountByAccountNumber($this->sender_account_number);
        } catch (\Throwable $th) {
            return;
        }

        if ($value > $senderAccount->balance) {
            $fail('The transaction amount cannot exceed the available balance.');
        }
    }
}
