<?php

namespace App\Console\Commands;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Console\Command;

class ExpirePendingBookings extends Command
{
    protected $signature = 'bookings:expire';

    protected $description = 'Batalkan pesanan pending yang telah melewati batas waktu pembayaran dan kembalikan stok kamar.';

    public function handle(BookingService $bookingService): int
    {
        $expiredBookings = Booking::where('status', BookingStatus::Pending)
            ->where('expires_at', '<=', now())
            ->get();

        $count = $expiredBookings->count();

        if ($count === 0) {
            $this->info('Tidak ada pesanan expired.');

            return Command::SUCCESS;
        }

        foreach ($expiredBookings as $booking) {
            $bookingService->cancelBooking($booking, 'expired');
            $this->line("Pesanan {$booking->booking_code} telah diubah menjadi expired dan stok kamar dikembalikan.");
        }

        $this->info("Berhasil memproses {$count} pesanan expired.");

        return Command::SUCCESS;
    }
}
