<?php

namespace Database\Seeders;

use App\Enums\PropertyType;
use App\Models\City;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\Review;
use App\Models\RoomInventory;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $cities = City::all()->keyBy('slug');
        $hotelFacilities = Facility::where('type', 'hotel')->get();
        $roomFacilities = Facility::where('type', 'room')->get();
        $demoUser = User::where('email', 'user@example.com')->first()
            ?? User::where('email', 'customer@example.com')->first();

        $hotelData = [
            // BALI (6 Hotels)
            [
                'city' => 'bali',
                'name' => 'The Mulia Resort & Villas',
                'star' => 5,
                'type' => PropertyType::Resort,
                'address' => 'Jl. Raya Nusa Dua Selatan, Kawasan Sawangan, Nusa Dua, Bali',
                'lat' => -8.8247,
                'lng' => 115.2185,
                'desc' => 'Resort mewah tepi pantai pemenang penghargaan dengan 9 kolam renang infinity berkelas dunia, spa eksklusif, dan pemandangan Samudra Hindia yang memukau.',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Mulia Grandeur King', 'bed' => '1 King Bed', 'size' => 57, 'price' => 2450000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Mulia Signature Ocean View', 'bed' => '1 King Bed', 'size' => 62, 'price' => 3200000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Royal Suite with Private Jacuzzi', 'bed' => '1 Super King Bed', 'size' => 95, 'price' => 5800000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'bali',
                'name' => 'AYANA Resort and Spa Bali',
                'star' => 5,
                'type' => PropertyType::Resort,
                'address' => 'Karang Mas Estate, Jl. Karang Mas Sejahtera, Jimbaran, Bali',
                'lat' => -8.7844,
                'lng' => 115.1432,
                'desc' => 'Terkenal dengan Rock Bar di atas tebing laut Jimbaran. Menawarkan pemandangan sunset terbaik di Bali dan 12 kolam renang bertingkat.',
                'images' => [
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Resort View Room', 'bed' => '1 King Bed', 'size' => 48, 'price' => 2200000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Ocean View King', 'bed' => '1 King Bed', 'size' => 52, 'price' => 2950000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Ocean Front Suite', 'bed' => '1 King Bed', 'size' => 98, 'price' => 5200000, 'guests' => 4, 'total' => 4],
                ],
            ],
            [
                'city' => 'bali',
                'name' => 'Padma Resort Ubud',
                'star' => 5,
                'type' => PropertyType::Resort,
                'address' => 'Banjar Carik, Desa Puhu, Payangan, Ubud, Bali',
                'lat' => -8.3845,
                'lng' => 115.2536,
                'desc' => 'Resort pegunungan di tengah hutan tropis lembah Payangan dengan kolam infinity air hangat terpanjang di Bali dan pemandangan lembah kabut pagi.',
                'images' => [
                    'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Premier Room Valley View', 'bed' => '1 King Bed', 'size' => 59, 'price' => 2100000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Premier Club Lounge', 'bed' => '1 King Bed', 'size' => 64, 'price' => 2850000, 'guests' => 2, 'total' => 6],
                    ['name' => 'Family Suite 2-Bedroom', 'bed' => '1 King & 2 Twins', 'size' => 110, 'price' => 4600000, 'guests' => 4, 'total' => 3],
                ],
            ],
            [
                'city' => 'bali',
                'name' => 'Courtyard by Marriott Seminyak',
                'star' => 4,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Camplung Tanduk No. 103, Seminyak, Bali',
                'lat' => -8.6923,
                'lng' => 115.1589,
                'desc' => 'Hotel modern 5 menit jalan kaki dari Pantai Seminyak, pusat belanja butik, kafe trendi, dan kehidupan malam tepi pantai Seminyak yang populer.',
                'images' => [
                    'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Room Garden View', 'bed' => '1 King Bed', 'size' => 38, 'price' => 1250000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Deluxe Room Pool View', 'bed' => '2 Twin Beds', 'size' => 38, 'price' => 1450000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Junior Suite with Balcony', 'bed' => '1 King Bed', 'size' => 60, 'price' => 2300000, 'guests' => 2, 'total' => 5],
                ],
            ],
            [
                'city' => 'bali',
                'name' => 'The Kuta Beach Heritage Hotel',
                'star' => 4,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Pantai Kuta, Br. Pande Mas, Kuta, Bali',
                'lat' => -8.7212,
                'lng' => 115.1698,
                'desc' => 'Hotel bertema kapal pesiar heritage tepat di seberang Pantai Kuta, menawarkan kolam renang atap dengan pemandangan langsung matahari terbenam.',
                'images' => [
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Classic Superior King', 'bed' => '1 King Bed', 'size' => 32, 'price' => 850000, 'guests' => 2, 'total' => 15],
                    ['name' => 'Deluxe Ocean Facing', 'bed' => '1 King Bed', 'size' => 36, 'price' => 1150000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Heritage Suite', 'bed' => '1 King Bed', 'size' => 58, 'price' => 1950000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'bali',
                'name' => 'Swiss-Belresort Watu Jimbar',
                'star' => 4,
                'type' => PropertyType::Resort,
                'address' => 'Jl. Danau Tamblingan No. 99A, Sanur, Bali',
                'lat' => -8.6978,
                'lng' => 115.2612,
                'desc' => 'Resort santai di Sanur dengan kolam laguna luas, jacuzzi outdoor di balkon, dan akses mudah ke pesisir pantai Sanur yang tenang.',
                'images' => [
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Room Plunge Pool', 'bed' => '1 King Bed', 'size' => 35, 'price' => 750000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Grand Deluxe Jacuzzi', 'bed' => '1 King Bed', 'size' => 42, 'price' => 980000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Penthouse Suite', 'bed' => '1 King Bed', 'size' => 70, 'price' => 1650000, 'guests' => 3, 'total' => 3],
                ],
            ],

            // JAKARTA (5 Hotels)
            [
                'city' => 'jakarta',
                'name' => 'Hotel Indonesia Kempinski Jakarta',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. M.H. Thamrin No. 1, Menteng, Jakarta Pusat',
                'lat' => -6.1951,
                'lng' => 106.8231,
                'desc' => 'Hotel bersejarah termegah di jantung Jakarta dengan pemandangan Bundaran HI legendaris, terhubung langsung dengan Grand Indonesia Shopping Town.',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Grand Deluxe City View', 'bed' => '1 King Bed', 'size' => 44, 'price' => 2600000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Executive Bundaran HI View', 'bed' => '1 King Bed', 'size' => 52, 'price' => 3400000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Diplomatic Suite', 'bed' => '1 Super King Bed', 'size' => 90, 'price' => 6500000, 'guests' => 3, 'total' => 2],
                ],
            ],
            [
                'city' => 'jakarta',
                'name' => 'The Ritz-Carlton Jakarta, Mega Kuningan',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. DR. Ide Anak Agung Gde Agung Kav. E.1.1 No. 1, Mega Kuningan, Jakarta Selatan',
                'lat' => -6.2289,
                'lng' => 106.8268,
                'desc' => 'Kemewahan kelas dunia di kawasan diplomatik dan bisnis terkemuka Jakarta Selatan, dilengkapi spa terbesar dan restoran prasmanan Asia terfavorit.',
                'images' => [
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Grand Room Skyline', 'bed' => '1 King Bed', 'size' => 63, 'price' => 2500000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Club Grand Room', 'bed' => '1 King Bed', 'size' => 63, 'price' => 3300000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Mayfair Suite', 'bed' => '1 King Bed', 'size' => 110, 'price' => 5900000, 'guests' => 3, 'total' => 3],
                ],
            ],
            [
                'city' => 'jakarta',
                'name' => 'Pullman Jakarta Central Park',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Podomoro City, Jl. Letjen S. Parman Kav. 28, Grogol, Jakarta Barat',
                'lat' => -6.1772,
                'lng' => 106.7904,
                'desc' => 'Hotel bintang lima berkonsep pop-art kontemporer di Jakarta Barat, terhubung langsung ke Central Park Mall dan Neo Soho Mall.',
                'images' => [
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Queen Room', 'bed' => '1 Queen Bed', 'size' => 36, 'price' => 1450000, 'guests' => 2, 'total' => 15],
                    ['name' => 'Executive Deluxe King', 'bed' => '1 King Bed', 'size' => 42, 'price' => 1850000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Suite Central Park', 'bed' => '1 King Bed', 'size' => 74, 'price' => 3100000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'jakarta',
                'name' => 'Artotel Gelora Senayan Jakarta',
                'star' => 4,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Pintu Satu Senayan, Gelora, Tanah Abang, Jakarta Pusat',
                'lat' => -6.2185,
                'lng' => 106.8021,
                'desc' => 'Pilihan hotel strategis tepat di kawasan olahraga GBK Senayan, dekat stasiun MRT Istora Mandiri dan pusat pameran JCC.',
                'images' => [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Studio 25 (Standard)', 'bed' => '1 Double Bed', 'size' => 25, 'price' => 780000, 'guests' => 2, 'total' => 14],
                    ['name' => 'Studio 35 (Deluxe)', 'bed' => '1 King Bed', 'size' => 35, 'price' => 990000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Artotel Suite', 'bed' => '1 King Bed', 'size' => 55, 'price' => 1650000, 'guests' => 2, 'total' => 4],
                ],
            ],
            [
                'city' => 'jakarta',
                'name' => 'Ibis Styles Jakarta Simatupang',
                'star' => 3,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Cilandak Tengah No. 23, TB Simatupang, Jakarta Selatan',
                'lat' => -6.2941,
                'lng' => 106.8005,
                'desc' => 'Hotel modern berdesain ceria dan bernuansa kasual di koridor bisnis TB Simatupang, cocok untuk pelancong bisnis dan keluarga.',
                'images' => [
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Standard Single / Double', 'bed' => '1 Double Bed', 'size' => 22, 'price' => 480000, 'guests' => 2, 'total' => 20],
                    ['name' => 'Superior Twin', 'bed' => '2 Single Beds', 'size' => 25, 'price' => 560000, 'guests' => 2, 'total' => 15],
                    ['name' => 'Family Suite', 'bed' => '1 King & 1 Sofa Bed', 'size' => 40, 'price' => 880000, 'guests' => 3, 'total' => 5],
                ],
            ],

            // BANDUNG (5 Hotels)
            [
                'city' => 'bandung',
                'name' => 'Padma Hotel Bandung',
                'star' => 5,
                'type' => PropertyType::Resort,
                'address' => 'Jl. Rancabentang No. 56-58, Ciumbuleuit, Bandung',
                'lat' => -6.8624,
                'lng' => 107.6047,
                'desc' => 'Terletak di lereng bukit hijau Ciumbuleuit dengan udara sejuk, kolam renang air panas berpemandangan lembah asri, dan afternoon tea gratis.',
                'images' => [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Hill View', 'bed' => '1 King Bed', 'size' => 36, 'price' => 1650000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Premier Valley View', 'bed' => '1 King Bed', 'size' => 42, 'price' => 2100000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Hillside Studio Suite', 'bed' => '1 King Bed', 'size' => 62, 'price' => 3400000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'bandung',
                'name' => 'The Trans Luxury Hotel Bandung',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Gatot Subroto No. 289, Batununggal, Bandung',
                'lat' => -6.9268,
                'lng' => 107.6361,
                'desc' => 'Hotel ikonik bintang 5 di Bandung dengan pantai pasir putih buatan di lantai 3, terintegrasi langsung dengan Trans Studio Mall.',
                'images' => [
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Premier King Room', 'bed' => '1 King Bed', 'size' => 45, 'price' => 1550000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Club Premier Room', 'bed' => '1 King Bed', 'size' => 45, 'price' => 2150000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Celebrity Suite', 'bed' => '1 Super King Bed', 'size' => 90, 'price' => 4200000, 'guests' => 3, 'total' => 3],
                ],
            ],
            [
                'city' => 'bandung',
                'name' => 'Grand Mercure Bandung Setiabudi',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Dr. Setiabudi No. 269-275, Isola, Sukasari, Bandung',
                'lat' => -6.8532,
                'lng' => 107.5954,
                'desc' => 'Menyuguhkan kolam renang air hangat berkilauan saat malam hari dengan lampu bawah air, dekat dengan rute wisata Lembang.',
                'images' => [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Superior Twin Bed', 'bed' => '2 Single Beds', 'size' => 32, 'price' => 950000, 'guests' => 2, 'total' => 14],
                    ['name' => 'Deluxe Pool View', 'bed' => '1 King Bed', 'size' => 38, 'price' => 1250000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Junior Suite with Balcony', 'bed' => '1 King Bed', 'size' => 58, 'price' => 2200000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'bandung',
                'name' => 'De Paviljoen Bandung',
                'star' => 4,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. R.E. Martadinata No. 68, Citarum, Bandung Wetan, Bandung',
                'lat' => -6.9077,
                'lng' => 107.6186,
                'desc' => 'Hotel bergaya kolonial modern di Jalan Riau (pusat factory outlet dan kafe legendaris Bandung), sangat nyaman untuk liburan keluarga.',
                'images' => [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Room Riau', 'bed' => '1 King Bed', 'size' => 28, 'price' => 680000, 'guests' => 2, 'total' => 15],
                    ['name' => 'Executive Room with Bathtub', 'bed' => '1 King Bed', 'size' => 36, 'price' => 890000, 'guests' => 2, 'total' => 10],
                    ['name' => 'The Paviljoen Suite', 'bed' => '1 King Bed', 'size' => 54, 'price' => 1500000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'bandung',
                'name' => 'Yello Hotel Paskal Bandung',
                'star' => 3,
                'type' => PropertyType::Hotel,
                'address' => 'Paskal Hyper Square, Jl. Pasir Kaliki No. 25, Andir, Bandung',
                'lat' => -6.9152,
                'lng' => 107.5998,
                'desc' => 'Pilihan hotel cerdas dekat Stasiun Kereta Bandung dan food court Paskal 23 Mall, cocok untuk penikmat kuliner lokal.',
                'images' => [
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Yello Room Double', 'bed' => '1 Double Bed', 'size' => 20, 'price' => 420000, 'guests' => 2, 'total' => 18],
                    ['name' => 'Yello Room Twin', 'bed' => '2 Single Beds', 'size' => 20, 'price' => 420000, 'guests' => 2, 'total' => 15],
                    ['name' => 'Urban Suite', 'bed' => '1 King Bed', 'size' => 38, 'price' => 780000, 'guests' => 2, 'total' => 5],
                ],
            ],

            // YOGYAKARTA (4 Hotels)
            [
                'city' => 'yogyakarta',
                'name' => 'The Phoenix Hotel Yogyakarta - MGallery',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Jend. Sudirman No. 9, Cokrodiningratan, Jetis, Yogyakarta',
                'lat' => -7.7828,
                'lng' => 110.3672,
                'desc' => 'Hotel butik heritage bernuansa kolonial 1918 di dekat Tugu Jogja, menggabungkan sentuhan Jawa klasik dengan fasilitas modern kontemporer.',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Superior Heritage Room', 'bed' => '1 King Bed', 'size' => 30, 'price' => 950000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Deluxe Balcony Room', 'bed' => '1 King Bed', 'size' => 35, 'price' => 1200000, 'guests' => 2, 'total' => 8],
                    ['name' => 'The Legendary Phoenix Suite', 'bed' => '1 King Bed', 'size' => 65, 'price' => 2400000, 'guests' => 3, 'total' => 3],
                ],
            ],
            [
                'city' => 'yogyakarta',
                'name' => 'Royal Ambarrukmo Yogyakarta',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Laksda Adisucipto No. 81, Caturtunggal, Depok, Sleman, Yogyakarta',
                'lat' => -7.7821,
                'lng' => 110.4005,
                'desc' => 'Hotel ikonik keraton Jogja dengan kompleks pendopo agung yang mempesona, taman istana, dan fasilitas spa tradisional Jawa.',
                'images' => [
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Merapi View', 'bed' => '1 King Bed', 'size' => 40, 'price' => 1150000, 'guests' => 2, 'total' => 14],
                    ['name' => 'Premier Balcony', 'bed' => '1 King Bed', 'size' => 40, 'price' => 1450000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Ambarrukmo Suite', 'bed' => '1 Super King Bed', 'size' => 80, 'price' => 2800000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'yogyakarta',
                'name' => 'Grand Aston Yogyakarta Hotel',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Urip Sumoharjo No. 37, Klitren, Gondokusuman, Yogyakarta',
                'lat' => -7.7831,
                'lng' => 110.3802,
                'desc' => 'Hotel bintang 5 di kawasan perbelanjaan Jalan Solo, dilengkapi kolam renang outdoor dan sky lounge di puncak gedung.',
                'images' => [
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Superior City View', 'bed' => '1 King Bed', 'size' => 32, 'price' => 850000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Deluxe Merapi View', 'bed' => '2 Single Beds', 'size' => 36, 'price' => 1050000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Aston Executive Suite', 'bed' => '1 King Bed', 'size' => 64, 'price' => 2100000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'yogyakarta',
                'name' => 'Harper Malioboro Yogyakarta',
                'star' => 4,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Mangkubumi No. 52, Gowongan, Jetis, Yogyakarta',
                'lat' => -7.7874,
                'lng' => 110.3668,
                'desc' => 'Hanya beberapa langkah dari Jalan Malioboro dan Stasiun Tugu Jogja, hotel ini menyajikan keramahan khas Yogyakarta dengan nuansa rustic modern.',
                'images' => [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Superior Room', 'bed' => '1 Double Bed', 'size' => 26, 'price' => 650000, 'guests' => 2, 'total' => 16],
                    ['name' => 'Deluxe Malioboro View', 'bed' => '1 King Bed', 'size' => 32, 'price' => 820000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Junior Suite', 'bed' => '1 King Bed', 'size' => 48, 'price' => 1450000, 'guests' => 3, 'total' => 5],
                ],
            ],

            // SURABAYA (3 Hotels)
            [
                'city' => 'surabaya',
                'name' => 'Hotel Majapahit Surabaya MGallery',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Tunjungan No. 65, Genteng, Surabaya',
                'lat' => -7.2598,
                'lng' => 112.7397,
                'desc' => 'Hotel cagar budaya nasional legendaris sejak tahun 1910 di Jalan Tunjungan dengan taman kolonial asri dan spa bersejarah.',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Heritage Classic Room', 'bed' => '1 King Bed', 'size' => 42, 'price' => 1350000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Majapahit Garden Suite', 'bed' => '1 King Bed', 'size' => 56, 'price' => 1950000, 'guests' => 2, 'total' => 6],
                    ['name' => 'Presidential Suite', 'bed' => '1 Super King Bed', 'size' => 120, 'price' => 5500000, 'guests' => 4, 'total' => 2],
                ],
            ],
            [
                'city' => 'surabaya',
                'name' => 'JW Marriott Hotel Surabaya',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Embong Malang No. 85-89, Kedungdoro, Tegalsari, Surabaya',
                'lat' => -7.2619,
                'lng' => 112.7366,
                'desc' => 'Hotel bisnis terkemuka di pusat kota Surabaya dengan layanan bintang lima, pusat kebugaran 24 jam, dan pilihan restoran gourmet internasional.',
                'images' => [
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe King Skyline', 'bed' => '1 King Bed', 'size' => 42, 'price' => 1400000, 'guests' => 2, 'total' => 14],
                    ['name' => 'Executive Lounge King', 'bed' => '1 King Bed', 'size' => 42, 'price' => 1950000, 'guests' => 2, 'total' => 10],
                    ['name' => 'JW Marriott Suite', 'bed' => '1 King Bed', 'size' => 84, 'price' => 3800000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'surabaya',
                'name' => 'Vasa Hotel Surabaya',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Mayjen HR. Muhammad No. 31, Putat Gede, Sukomanunggal, Surabaya',
                'lat' => -7.2842,
                'lng' => 112.6954,
                'desc' => 'Hotel modern mewah di Surabaya Barat dengan desain arsitektur futuristik, helipad, dan chapel kaca untuk resepsi pernikahan eksklusif.',
                'images' => [
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Select Room King', 'bed' => '1 King Bed', 'size' => 36, 'price' => 1150000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Executive Club Room', 'bed' => '1 King Bed', 'size' => 40, 'price' => 1650000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Vasa Royal Suite', 'bed' => '1 King Bed', 'size' => 78, 'price' => 3200000, 'guests' => 3, 'total' => 3],
                ],
            ],

            // SEMARANG (3 Hotels)
            [
                'city' => 'semarang',
                'name' => 'PO Hotel Semarang',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Pemuda No. 118, Sekayu, Semarang Tengah, Semarang',
                'lat' => -6.9808,
                'lng' => 110.4144,
                'desc' => 'Terhubung langsung dengan Pollux Paragon Mall di pusat kota Semarang, menawarkan kemewahan kamar luas dan akses 5 menit ke Lawang Sewu.',
                'images' => [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Superior City View', 'bed' => '1 King Bed', 'size' => 34, 'price' => 950000, 'guests' => 2, 'total' => 14],
                    ['name' => 'Executive Club King', 'bed' => '1 King Bed', 'size' => 42, 'price' => 1350000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Presidential Suite', 'bed' => '1 Super King Bed', 'size' => 96, 'price' => 3500000, 'guests' => 3, 'total' => 2],
                ],
            ],
            [
                'city' => 'semarang',
                'name' => 'Gumaya Tower Hotel Semarang',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Gajahmada No. 59-61, Kembangsari, Semarang Tengah, Semarang',
                'lat' => -6.9782,
                'lng' => 110.4208,
                'desc' => 'Hotel pencakar langit terkemuka dengan restoran The Sky Lounge di lantai 17 dan layanan fasilitas konferensi terlengkap di Jawa Tengah.',
                'images' => [
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'New Deluxe Room', 'bed' => '1 King Bed', 'size' => 38, 'price' => 1050000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Grand Tower Club', 'bed' => '1 King Bed', 'size' => 45, 'price' => 1500000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Gumaya Royal Suite', 'bed' => '1 King Bed', 'size' => 85, 'price' => 3200000, 'guests' => 3, 'total' => 3],
                ],
            ],
            [
                'city' => 'semarang',
                'name' => 'Aston Inn Pandanaran Semarang',
                'star' => 4,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Pandanaran No. 40, Pekunden, Semarang Tengah, Semarang',
                'lat' => -6.9881,
                'lng' => 110.4137,
                'desc' => 'Dekat dengan sentra oleh-oleh khas Pandanaran Semarang dan Simpang Lima, memiliki infinity pool rooftop yang menawan.',
                'images' => [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Room', 'bed' => '1 Double Bed', 'size' => 26, 'price' => 580000, 'guests' => 2, 'total' => 15],
                    ['name' => 'Executive Room', 'bed' => '1 King Bed', 'size' => 34, 'price' => 780000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Suite Room Simpang Lima', 'bed' => '1 King Bed', 'size' => 52, 'price' => 1350000, 'guests' => 3, 'total' => 4],
                ],
            ],

            // MALANG (2 Hotels)
            [
                'city' => 'malang',
                'name' => 'The Shalimar Boutique Hotel',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Cerme No. 16, Oro-oro Dowo, Klojen, Malang',
                'lat' => -7.9719,
                'lng' => 112.6288,
                'desc' => 'Bangunan peninggalan Belanda era 1930-an yang dipugar mewah menjadi hotel butik bintang 5 paling prestisius di Kota Malang.',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Deluxe Heritage Room', 'bed' => '1 King Bed', 'size' => 32, 'price' => 1100000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Executive Balcony Room', 'bed' => '1 King Bed', 'size' => 40, 'price' => 1450000, 'guests' => 2, 'total' => 6],
                    ['name' => 'The Shalimar Royal Suite', 'bed' => '1 King Bed', 'size' => 75, 'price' => 2750000, 'guests' => 3, 'total' => 2],
                ],
            ],
            [
                'city' => 'malang',
                'name' => 'Grand Mercure Malang Mirama',
                'star' => 5,
                'type' => PropertyType::Hotel,
                'address' => 'Jl. Raden Panji Suroso No. 7, Purwodadi, Blimbing, Malang',
                'lat' => -7.9351,
                'lng' => 112.6511,
                'desc' => 'Hotel termewah di gerbang masuk Malang dengan ballroom megah, kolam renang outdoor berpemandangan Gunung Arjuno, dan restoran tematik.',
                'images' => [
                    'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Classic King Mountain View', 'bed' => '1 King Bed', 'size' => 36, 'price' => 950000, 'guests' => 2, 'total' => 12],
                    ['name' => 'Deluxe Executive', 'bed' => '1 King Bed', 'size' => 42, 'price' => 1300000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Mirama Family Suite', 'bed' => '1 King & 1 Twin', 'size' => 68, 'price' => 2400000, 'guests' => 4, 'total' => 4],
                ],
            ],

            // LOMBOK (2 Hotels)
            [
                'city' => 'lombok',
                'name' => 'Katamaran Hotel & Resort Senggigi',
                'star' => 5,
                'type' => PropertyType::Resort,
                'address' => 'Jl. Raya Senggigi, Mangsit, Senggigi, Lombok Barat',
                'lat' => -8.4721,
                'lng' => 116.0352,
                'desc' => 'Resort pantai tepi laut Mangsit dengan kolam kaca transparan (glass-bottom pool) ikonik dan pemandangan Gunung Agung Bali saat senja.',
                'images' => [
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'Premier Ocean View', 'bed' => '1 King Bed', 'size' => 52, 'price' => 1750000, 'guests' => 2, 'total' => 10],
                    ['name' => 'Ocean Front Suite', 'bed' => '1 King Bed', 'size' => 65, 'price' => 2400000, 'guests' => 2, 'total' => 6],
                    ['name' => 'Villa with Private Pool', 'bed' => '1 King Bed', 'size' => 110, 'price' => 4500000, 'guests' => 3, 'total' => 4],
                ],
            ],
            [
                'city' => 'lombok',
                'name' => 'Jeeva Klui Resort Lombok',
                'star' => 5,
                'type' => PropertyType::Resort,
                'address' => 'Jl. Raya Klui Beach No. 1, Malaka, Pemenang, Lombok Utara',
                'lat' => -8.4522,
                'lng' => 116.0305,
                'desc' => 'Resort butik eksotis berkonsep arsitektur tradisional Sasak di teluk Klui yang terpencil, menawarkan ketenangan alam pantai Lombok yang otentik.',
                'images' => [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1000&auto=format&fit=crop',
                ],
                'rooms' => [
                    ['name' => 'AnFlora Garden Suite', 'bed' => '1 King Bed', 'size' => 54, 'price' => 1600000, 'guests' => 2, 'total' => 8],
                    ['name' => 'Akasha Ocean Villa', 'bed' => '1 King Bed', 'size' => 68, 'price' => 2200000, 'guests' => 2, 'total' => 6],
                    ['name' => 'Amora Beachfront Pool Villa', 'bed' => '1 King Bed', 'size' => 95, 'price' => 3900000, 'guests' => 3, 'total' => 3],
                ],
            ],
        ];

        $today = Carbon::today();
        $dateRange = CarbonPeriod::create($today, (clone $today)->addDays(89));
        $allInventories = [];

        foreach ($hotelData as $data) {
            $city = $cities->get($data['city']);
            if (! $city) {
                continue;
            }

            $hotel = Hotel::create([
                'city_id' => $city->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']).'-'.Str::random(4),
                'description' => $data['desc'],
                'address' => $data['address'],
                'latitude' => $data['lat'],
                'longitude' => $data['lng'],
                'star_rating' => $data['star'],
                'property_type' => $data['type'],
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'policy' => "1. Waktu check-in mulai pukul 14:00 WIB, check-out maksimal pukul 12:00 WIB.\n2. Tamu wajib menunjukkan kartu identitas sah (KTP/Paspor) saat check-in.\n3. Pembatalan gratis berlaku hingga 3 hari sebelum tanggal kedatangan.",
                'is_active' => true,
            ]);

            // Attach Images
            foreach ($data['images'] as $index => $imgPath) {
                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'path' => $imgPath,
                    'is_cover' => $index === 0,
                    'sort_order' => $index,
                ]);
            }

            // Attach Hotel Facilities
            $hotel->facilities()->sync($hotelFacilities->random(min(6, $hotelFacilities->count()))->pluck('id'));

            // Create 3 Room Types per Hotel
            foreach ($data['rooms'] as $roomInfo) {
                $roomType = RoomType::create([
                    'hotel_id' => $hotel->id,
                    'name' => $roomInfo['name'],
                    'description' => "Nikmati kenyamanan menginap di {$roomInfo['name']} seluas {$roomInfo['size']} m² dengan fasilitas lengkap berkualitas tinggi.",
                    'max_guests' => $roomInfo['guests'],
                    'bed_type' => $roomInfo['bed'],
                    'size_m2' => $roomInfo['size'],
                    'base_price' => $roomInfo['price'],
                    'total_rooms' => $roomInfo['total'],
                    'image' => $data['images'][0] ?? 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&auto=format&fit=crop',
                ]);

                // Attach Room Facilities
                $roomType->facilities()->sync($roomFacilities->random(min(5, $roomFacilities->count()))->pluck('id'));

                // Generate 90 days inventories
                foreach ($dateRange as $date) {
                    $dateStr = $date->format('Y-m-d');
                    // Weekend surcharge (+15%)
                    $isWeekend = in_array($date->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY]);
                    $dailyPrice = $isWeekend ? round($roomInfo['price'] * 1.15) : $roomInfo['price'];

                    $allInventories[] = [
                        'room_type_id' => $roomType->id,
                        'date' => $dateStr,
                        'available_rooms' => $roomInfo['total'],
                        'price' => $dailyPrice,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Chunk insert if batch exceeds 1000 items
                    if (count($allInventories) >= 1000) {
                        RoomInventory::insert($allInventories);
                        $allInventories = [];
                    }
                }
            }

            // Create initial reviews for hotel
            if ($demoUser) {
                Review::firstOrCreate(
                    ['hotel_id' => $hotel->id, 'user_id' => $demoUser->id],
                    [
                        'booking_id' => null, // seeded review without booking constraint
                        'rating' => fake()->randomElement([4, 5, 5]),
                        'comment' => 'Pengalaman menginap yang luar biasa! Pelayanan staf sangat ramah, kamar bersih dan luas, sarapannya lezat.',
                    ]
                );
            }
        }

        // Insert remaining inventories
        if (! empty($allInventories)) {
            RoomInventory::insert($allInventories);
        }
    }
}
