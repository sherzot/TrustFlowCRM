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
	 * Bu migration mavjud Deal'larning ko'pchiligini 'open' status'ga o'zgartiradi
	 * Kanban Board'da ko'rsatilishi uchun
	 */
	public function up(): void
	{
		// Barcha Deal'larni olish
		$allDeals = DB::table('deals')->get();

		if ($allDeals->isEmpty()) {
			return; // Deal'lar yo'q, hech narsa qilmaslik
		}

		// Har bir Deal uchun:
		// - Agar stage 'won' bo'lsa va status 'open' bo'lsa, status'ni 'won' qilish
		// - Agar stage 'lost' bo'lsa va status 'open' bo'lsa, status'ni 'lost' qilish
		// - Boshqa hollarda status'ni 'open' qilish (Kanban Board uchun)

		foreach ($allDeals as $deal) {
			$newStatus = 'open';

			// Agar stage 'won' yoki 'lost' bo'lsa va status 'open' bo'lsa,
			// status'ni stage'ga moslashtirish
			if ($deal->stage === 'won' && $deal->status === 'open') {
				$newStatus = 'won';
			} elseif ($deal->stage === 'lost' && $deal->status === 'open') {
				$newStatus = 'lost';
			} elseif ($deal->status === 'won' || $deal->status === 'lost') {
				// Agar status allaqachon 'won' yoki 'lost' bo'lsa, o'zgartirmaslik
				continue;
			} else {
				// Boshqa hollarda 'open' qilish
				$newStatus = 'open';
			}

			DB::table('deals')
				->where('id', $deal->id)
				->update(['status' => $newStatus]);
		}

		// Yana bir bor: agar Deal'lar hali ham 'won' yoki 'lost' bo'lsa,
		// lekin stage 'won' yoki 'lost' emas bo'lsa, status'ni 'open' qilish
		DB::table('deals')
			->whereIn('status', ['won', 'lost'])
			->whereNotIn('stage', ['won', 'lost'])
			->update(['status' => 'open']);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		// Rollback qilish mumkin emas - status'lar o'zgartirilgan
		// Faqat ogohlantirish
		// throw new \Exception('Cannot rollback deals status fix migration.');
	}
};
