<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'room_type_id' => ['required', 'exists:room_types,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'rooms' => ['required', 'integer', 'min:1', 'max:10'],
            'guests' => ['required', 'integer', 'min:1', 'max:20'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:30'],
            'special_request' => ['nullable', 'string', 'max:1000'],
            'voucher_code' => ['nullable', 'string', 'max:50'],
            'payment_method' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'room_type_id.required' => 'Pilihan kamar tidak valid.',
            'check_in.required' => 'Tanggal check-in wajib diisi.',
            'check_out.required' => 'Tanggal check-out wajib diisi.',
            'check_out.after' => 'Tanggal check-out harus setelah tanggal check-in.',
            'guest_name.required' => 'Nama lengkap tamu wajib diisi.',
            'guest_email.required' => 'Email tamu wajib diisi.',
            'guest_phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
        ];
    }
}
