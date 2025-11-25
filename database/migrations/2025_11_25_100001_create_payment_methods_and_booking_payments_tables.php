<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('description');
            $table->json('instructions');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, paid, failed, cancelled
            $table->string('payment_reference')->nullable();
            $table->json('payment_details')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // Insert default payment methods
        DB::table('payment_methods')->insert([
            [
                'name' => 'Bank Transfer - BCA',
                'code' => 'bca_va',
                'description' => 'Transfer ke Virtual Account BCA',
                'instructions' => json_encode([
                    'account_name' => 'PT GlowHub Indonesia',
                    'account_number' => '1234567890',
                    'bank_name' => 'Bank Central Asia (BCA)',
                    'steps' => [
                        '1. Login ke internet banking atau mobile banking BCA',
                        '2. Pilih menu Transfer -> Transfer ke Virtual Account',
                        '3. Masukkan nomor Virtual Account yang tertera',
                        '4. Masukkan jumlah pembayaran sesuai tagihan',
                        '5. Konfirmasi dan selesaikan pembayaran'
                    ]
                ]),
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bank Transfer - Mandiri',
                'code' => 'mandiri_va',
                'description' => 'Transfer ke Virtual Account Mandiri',
                'instructions' => json_encode([
                    'account_name' => 'PT GlowHub Indonesia',
                    'account_number' => '0987654321',
                    'bank_name' => 'Bank Mandiri',
                    'steps' => [
                        '1. Login ke internet banking atau mobile banking Mandiri',
                        '2. Pilih menu Pembayaran -> Multi Payment',
                        '3. Pilih penyedia jasa: GlowHub',
                        '4. Masukkan nomor Virtual Account',
                        '5. Masukkan jumlah pembayaran dan konfirmasi'
                    ]
                ]),
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'E-Wallet - GoPay',
                'code' => 'gopay',
                'description' => 'Bayar menggunakan GoPay',
                'instructions' => json_encode([
                    'steps' => [
                        '1. Buka aplikasi Gojek',
                        '2. Pilih menu GoPay',
                        '3. Pilih Bayar',
                        '4. Scan QR Code atau masukkan nomor Virtual Account',
                        '5. Masukkan jumlah pembayaran',
                        '6. Konfirmasi pembayaran'
                    ]
                ]),
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'E-Wallet - OVO',
                'code' => 'ovo',
                'description' => 'Bayar menggunakan OVO',
                'instructions' => json_encode([
                    'steps' => [
                        '1. Buka aplikasi OVO',
                        '2. Pilih menu Transfer atau Bayar',
                        '3. Scan QR Code atau masukkan nomor tujuan',
                        '4. Masukkan jumlah pembayaran',
                        '5. Konfirmasi pembayaran dengan PIN'
                    ]
                ]),
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'E-Wallet - Dana',
                'code' => 'dana',
                'description' => 'Bayar menggunakan DANA',
                'instructions' => json_encode([
                    'steps' => [
                        '1. Buka aplikasi DANA',
                        '2. Pilih menu Bayar',
                        '3. Scan QR Code atau pilih Virtual Account',
                        '4. Masukkan jumlah pembayaran',
                        '5. Konfirmasi pembayaran'
                    ]
                ]),
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('booking_payments');
        Schema::dropIfExists('payment_methods');
    }
};
