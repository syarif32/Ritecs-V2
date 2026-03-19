<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Membership;
use Carbon\Carbon;

class UserMembershipSeeder extends Seeder
{
    public function run(): void
    {
         \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Hapus data lama (optional)
        User::truncate();
        Membership::truncate();

        for ($i = 1; $i <= 100; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $email = strtolower($firstName . $i . '@example.com');
            
            // Insert user
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make('password'),
                'nik' => fake()->numerify('3276##########'),
                'birthday' => fake()->date('Y-m-d', '2003-01-01'),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'city' => fake()->city(),
                'province' => fake()->state(),
                'img_path' => 'default.png',
                'ktp_path' => 'ktp_dummy.png',
                'acc_status' => 'active',
                'email_verified_at' => now(),
            ]);

            // Tentukan apakah membership aktif atau tidak
            $isActive = rand(0, 1); // 0 = tidak aktif, 1 = aktif

            if ($isActive) {
                $start = Carbon::now()->subDays(rand(0, 30));
                $end = $start->copy()->addYear();
                $status = 'active';
            } else {
                $start = Carbon::now()->subYears(2);
                $end = $start->copy()->addYear(); // sudah lewat
                $status = 'inactive';
            }

            // Insert membership
            Membership::create([
                'user_id' => $user->user_id,
                'start_date' => $start,
                'end_date' => $end,
                'member_number' => 'MBR-' . Str::upper(Str::random(6)),
                'status' => $status,
            ]);
        }

        echo "✅ 100 dummy users & memberships inserted successfully!\n";
    }
}
