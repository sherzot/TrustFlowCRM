<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * 
	 * Bu migration duplicate account va contact'larni o'chiradi
	 * va unique constraint'lar qo'shadi
	 */
	public function up(): void
	{
		// Accounts jadvalida duplicate'lar uchun tekshirish va o'chirish
		// Bir xil name, email, phone va tenant_id bo'lgan account'lar duplicate hisoblanadi
		$duplicateAccounts = DB::table('accounts')
			->select('name', 'email', 'phone', 'tenant_id', DB::raw('MIN(id) as keep_id'))
			->whereNotNull('name')
			->whereNotNull('email')
			->groupBy('name', 'email', 'phone', 'tenant_id')
			->havingRaw('COUNT(*) > 1')
			->get();

		foreach ($duplicateAccounts as $duplicate) {
			// Eng eski ID'ni saqlab qolish, qolganlarini o'chirish
			DB::table('accounts')
				->where('name', $duplicate->name)
				->where('email', $duplicate->email)
				->where('phone', $duplicate->phone)
				->where('tenant_id', $duplicate->tenant_id)
				->where('id', '!=', $duplicate->keep_id)
				->delete();
		}

		// Contacts jadvalida duplicate'lar uchun tekshirish va o'chirish
		// Bir xil email, phone va tenant_id bo'lgan contact'lar duplicate hisoblanadi
		$duplicateContacts = DB::table('contacts')
			->select('email', 'phone', 'tenant_id', DB::raw('MIN(id) as keep_id'))
			->whereNotNull('email')
			->whereNotNull('phone')
			->groupBy('email', 'phone', 'tenant_id')
			->havingRaw('COUNT(*) > 1')
			->get();

		foreach ($duplicateContacts as $duplicate) {
			// Eng eski ID'ni saqlab qolish, qolganlarini o'chirish
			DB::table('contacts')
				->where('email', $duplicate->email)
				->where('phone', $duplicate->phone)
				->where('tenant_id', $duplicate->tenant_id)
				->where('id', '!=', $duplicate->keep_id)
				->delete();
		}
	}

	/**
	 * Reverse the migrations.
	 * 
	 * Bu migration'ni rollback qilish mumkin emas,
	 * chunki o'chirilgan ma'lumotlarni qayta tiklash mumkin emas
	 */
	public function down(): void
	{
		// Rollback qilish mumkin emas - ma'lumotlar o'chirilgan
		// Faqat ogohlantirish
		throw new \Exception('Cannot rollback duplicate removal migration. Data has been permanently deleted.');
	}
};
