<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\RoomInventory;
use App\Models\RoomType;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomTypeController extends Controller
{
    public function index(Hotel $hotel): View
    {
        $hotel->load('city');
        $rooms = $hotel->roomTypes()->with('facilities')->withCount('bookings')->get();

        return view('admin.rooms.index', compact('hotel', 'rooms'));
    }

    public function create(Hotel $hotel): View
    {
        $facilities = Facility::where('type', 'room')->orderBy('name')->get();

        return view('admin.rooms.create', compact('hotel', 'facilities'));
    }

    public function store(Request $request, Hotel $hotel): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'max_guests' => ['required', 'integer', 'min:1', 'max:10'],
            'bed_type' => ['required', 'string', 'max:100'],
            'size_m2' => ['nullable', 'integer', 'min:5', 'max:500'],
            'base_price' => ['required', 'numeric', 'min:50000'],
            'total_rooms' => ['required', 'integer', 'min:1', 'max:100'],
            'image' => ['nullable', 'url', 'max:1000'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
        ]);

        $room = $hotel->roomTypes()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'max_guests' => $validated['max_guests'],
            'bed_type' => $validated['bed_type'],
            'size_m2' => $validated['size_m2'] ?? null,
            'base_price' => $validated['base_price'],
            'total_rooms' => $validated['total_rooms'],
            'image' => ($validated['image'] ?? null) ?: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&auto=format&fit=crop',
        ]);

        if (! empty($validated['facilities'])) {
            $room->facilities()->sync($validated['facilities']);
        }

        // Auto-generate inventory for next 30 days
        $period = CarbonPeriod::create(today(), today()->addDays(30));
        foreach ($period as $date) {
            RoomInventory::updateOrCreate(
                ['room_type_id' => $room->id, 'date' => $date->format('Y-m-d')],
                ['available_rooms' => $room->total_rooms, 'price' => $room->base_price]
            );
        }

        return redirect()->route('admin.hotels.rooms.index', $hotel->id)
            ->with('status', 'Tipe kamar dan inventori 30 hari berhasil ditambahkan.');
    }

    public function edit(Hotel $hotel, RoomType $room): View
    {
        $room->load('facilities');
        $facilities = Facility::where('type', 'room')->orderBy('name')->get();

        return view('admin.rooms.edit', compact('hotel', 'room', 'facilities'));
    }

    public function update(Request $request, Hotel $hotel, RoomType $room): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'max_guests' => ['required', 'integer', 'min:1', 'max:10'],
            'bed_type' => ['required', 'string', 'max:100'],
            'size_m2' => ['nullable', 'integer', 'min:5', 'max:500'],
            'base_price' => ['required', 'numeric', 'min:50000'],
            'total_rooms' => ['required', 'integer', 'min:1', 'max:100'],
            'image' => ['nullable', 'url', 'max:1000'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
        ]);

        $room->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'max_guests' => $validated['max_guests'],
            'bed_type' => $validated['bed_type'],
            'size_m2' => $validated['size_m2'] ?? null,
            'base_price' => $validated['base_price'],
            'total_rooms' => $validated['total_rooms'],
            'image' => $validated['image'] ?: $room->image,
        ]);

        if (isset($validated['facilities'])) {
            $room->facilities()->sync($validated['facilities']);
        }

        return redirect()->route('admin.hotels.rooms.index', $hotel->id)
            ->with('status', 'Tipe kamar berhasil diperbarui.');
    }

    public function destroy(Hotel $hotel, RoomType $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('admin.hotels.rooms.index', $hotel->id)
            ->with('status', 'Tipe kamar berhasil dihapus.');
    }

    public function inventories(Hotel $hotel, RoomType $room): View
    {
        $inventories = $room->inventories()
            ->where('date', '>=', today()->format('Y-m-d'))
            ->where('date', '<=', today()->addDays(30)->format('Y-m-d'))
            ->orderBy('date')
            ->get();

        return view('admin.rooms.inventories', compact('hotel', 'room', 'inventories'));
    }

    public function updateInventories(Request $request, Hotel $hotel, RoomType $room): RedirectResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'available_rooms' => ['required', 'integer', 'min:0', 'max:'.$room->total_rooms],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $period = CarbonPeriod::create($validated['start_date'], $validated['end_date']);

        foreach ($period as $date) {
            RoomInventory::updateOrCreate(
                [
                    'room_type_id' => $room->id,
                    'date' => $date->format('Y-m-d'),
                ],
                [
                    'available_rooms' => $validated['available_rooms'],
                    'price' => $validated['price'],
                ]
            );
        }

        return back()->with('status', 'Inventori dan harga tanggal terpilih berhasil diperbarui.');
    }
}
