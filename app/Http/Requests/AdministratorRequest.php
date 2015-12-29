<?php


namespace App\Http\Requests;

use App\Traits\AuthTrait;


class AdministratorRequest extends Request
{

    use AuthTrait;

    /**
     * Default rules for storing new Administrator.
     *
     * @var array
     */
    private $storeRules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch (true) {
            case $this->wantsToList():
            case $this->wantsToShow():
                if ($this->hasRoles(['owner', 'administrator'])) {
                    return true;
                }
                break;
            case $this->wantsToStore():
            case $this->wantsToUpdate():
            case $this->wantsToDestroy():
                if ($this->hasRoles(['owner'])) {
                    return true;
                }
                break;
        }

        return false;
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
                $this->storeRules['email'] = 'required|email|between:5,100|unique:users,email,' . $this->route('administrators');

                $rules = $this->storeRules;
                break;
            default:
                $rules = [];
        }

        return $rules;
    }
}
