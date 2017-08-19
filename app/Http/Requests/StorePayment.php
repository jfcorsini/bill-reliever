<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePayment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $memberId = $this->request->get('member_id') ?? null; 
        $member    = \App\Member::find($memberId);
        if ($member->user_id != Auth::user()->id) {
            return redirect('/login');
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'member_id'   => 'required',
            'description' => 'required',
            'value'       => 'required',
        ];
    }
}
