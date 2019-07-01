<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/31/2019
 * Time: 4:08 PM
 */

namespace App\Validation\Fleet;


use Illuminate\Foundation\Http\FormRequest;

class FleetValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'fleetLog' => 'string',
        ];
    }
}
