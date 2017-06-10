<?php namespace App\Http\Requests;

use Illuminate\Http\Request;

class IdeaFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->can_post()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:50',
            'body' => 'required',
            'like' => 'integer',
            'dislike' => 'integer',
            'reported' => 'integer'
        ];
    }
}