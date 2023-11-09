<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'delivery.method' => ['required', 'exists:App\Models\Shipping,method'],
            'delivery.address' => ['required', 'string'],
            'payment.method' => ['required', 'exists:App\Models\Payment,method'],
            'timeDelivery.date' => ['required', 'date'],
            'contacts.from.name' => ['required', 'string'],
            'contacts.from.phone' => ['required', 'string'],
            'contacts.to.name' => ['required', 'string'],
            'contacts.to.phone' => ['required', 'string'],
            'message' => ['required', 'string', 'nullable'],
            'rules' => ['required']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'delivery.method' => 'Выберите метод доставки.',
            'delivery.address' => 'Введите адрес доставки.',
            'timeDelivery.date' => 'Укажите дату доставки.',
            'timeDelivery.time' => 'Укажите время доставки.',
            'contacts.from.name' => 'Имя отправиля обязательное поле.',
            'contacts.from.phone' => 'Номер отправителя обязательное поле.',
            'contacts.to.name' => 'Имя получателя обязательное поле.',
            'contacts.to.phone' => 'Номер получателя обязательное поле.',
            'payment.method' => 'Выберите метод оплаты.',
            'message' => 'Комментарий обязателен.',
            'rules' => 'Согласие обязательно.',
        ];
    }
}
