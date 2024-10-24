<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Activity;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// --
		// Create users and assign random activities
		User::factory(10)->create()->each(function ($user) {
			Activity::factory(count: rand(5, 10))->create(['user_id' => $user->id]);

			$totalPoints = Activity::where('user_id', $user->id)->sum('points');
			$user->update(['total_points' => $totalPoints]);
		});

		// --
		// Calculate ranks
		$this->calculateRank();
	}

	/**
	 * Calculate rank and update user's rank.
	 */
	public function calculateRank()
	{
		$users = User::orderBy('total_points', 'desc')->get();

		$rank = 1;
		$prevPoints = null;
		foreach ($users as $index => $user) {
			if ($prevPoints !== null && $user->total_points === $prevPoints) {
				$user->update(['rank' => $rank]);
			} else {
				$rank = $index + 1;
				$user->update(['rank' => $rank]);
			}
			$prevPoints = $user->total_points;
		}
	}
}
