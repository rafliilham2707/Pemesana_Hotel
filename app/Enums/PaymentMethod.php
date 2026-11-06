<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Midtrans = 'midtrans';
    case BankTransfer = 'bank_transfer';
    case CreditCard = 'credit_card';
    case Qris = 'qris';
    case EWallet = 'e_wallet';

    public function label(): string
    {
        return match ($this) {
            self::Midtrans => 'Midtrans Snap',
            self::BankTransfer => 'Transfer Bank (Virtual Account)',
            self::CreditCard => 'Kartu Kredit / Debit',
            self::Qris => 'QRIS (GoPay, OVO, Dana)',
            self::EWallet => 'Dompet Digital',
        };
    }
}
