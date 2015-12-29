<?php


namespace App\Http\Requests;

use App\Traits\AuthTrait;


class MemberRequest extends Request
{

    use AuthTrait;

    /**
     * Rules used for creating new User.
     *
     * @var array
     */
    protected $storeRules = [
        'email' => 'required|email|between:5,100|unique:users,email',
        'password' => 'required|between:5,100'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authorization = false;

        switch (true) {
            case $this->wantsToList():
            case $this->wantsToDestroy():
                if ($this->hasRoles(['owner', 'administrator'])) {
                    $authorization = true;
                }
                break;
            case $this->wantsToStore():
                $authorization = true;
                break;
            case $this->wantsToShow():
            case $this->wantsToUpdate():
                if ($this->hasRoles(['owner', 'administrator']) || $this->isRequestedUser($this->route('members'))) {
                    $authorization = true;
                }
                break;
            default:
                $authorization = false;
        }

        return $authorization;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (true) {
            case $this->wantsToList():
                $rules = $this->listRules;
                break;
            case $this->wantsToStore():
                $rules = $this->storeRules;
                break;
            case $this->wantsToUpdate():
                $this->storeRules['email'] = 'required|email|between:5,100|unique:users,email,' . $this->route('members');

                $rules = $this->storeRules;
                break;
            default:
                $rules = [];
        }

        return $rules;
    }

}
