<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class ArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        switch ($this->getPathInfo()) {
            case '/v1/article/store':
                return [
                    'tag'     => 'required',
                    'title'   => 'required',
                    'content' => 'required',
                ];
                break;
            case '/v1/article/update':
                return [
                    'id'      => 'required',
                    'tag'     => 'required',
                    'title'   => 'required',
                    'content' => 'required',
                ];
                break;
            case '/v1/article/delete':
                return [
                    'id' => 'required',
                ];
                break;
        }
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'id.required'      => 'ID 不能为空',
            'tag.required'     => '标签不能为空',
            'title.required'   => '标题不能为空',
            'content.required' => '内容不能为空',
        ];
    }
}
