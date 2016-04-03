<?php


namespace App\Http\Requests;


class CategoryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            case $this->wantsToShow():
                $rules = [
                    'with' => 'in:translation,translations'
                ];
                break;
            case $this->wantsToStore():
            case $this->wantsToUpdate():
                $rules = [
                    'parent_id' => 'exists:categories,id'
                ];
                break;
            default:
                $rules = [];
                break;
        }

        return $rules;
    }
}
