<?php

namespace Database\Seeders;

use App\Enums\VoucherType;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'STAYHEMAT20',
                'name' => 'Diskon 20% Liburan Nyaman',
                'type' => VoucherType::Percent,
                'value' => 20,
                'min_spend' => 500000,
                'max_discount' => 250000,
                'quota' => 200,
                'used_count' => 14,
                'valid_from' => Carbon::today()->subDays(10)->format('Y-m-d'),
                'valid_until' => Carbon::today()->addDays(90)->format('Y-m-d'),
                'is_active' => true,
            ],
            [
                'code' => 'HOTELMURAH10',
                'name' => 'Diskon 10% Semua Kamar',
                'type' => VoucherType::Percent,
                'value' => 10,
                'min_spend' => 300000,
                'max_discount' => 150000,
                'quota' => 500,
                'used_count' => 35,
                'valid_from' => Carbon::today()->subDays(5)->format('Y-m-d'),
                'valid_until' => Carbon::today()->addDays(120)->format('Y-m-d'),
                'is_active' => true,
            ],
            [
                'code' => 'WELCOME50K',
                'name' => 'Potongan Langsung Rp 50.000',
                'type' => VoucherType::Fixed,
                'value' => 50000,
                'min_spend' => 400000,
                'max_discount' => null,
                'quota' => 300,
                'used_count' => 22,
                'valid_from' => Carbon::today()->subDays(5)->format('Y-m-d'),
                'valid_until' => Carbon::today()->addDays(60)->format('Y-m-d'),
                'is_active' => true,
            ],
            [
                'code' => 'SUITE100K',
                'name' => 'Potongan Kamar Suite Rp 100.000',
                'type' => VoucherType::Fixed,
                'value' => 100000,
                'min_spend' => 1000000,
                'max_discount' => null,
                'quota' => 100,
                'used_count' => 5,
                'valid_from' => Carbon::today()->subDays(1)->format('Y-m-d'),
                'valid_until' => Carbon::today()->addDays(45)->format('Y-m-d'),
                'is_active' => true,
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::firstOrCreate(['code' => $voucher['code']], $voucher);
        }
    }
}
