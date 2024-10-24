<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class LeaderboardController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$filter = $request->input('filter', 'all');

		// --
		// Get users with activities
		$allUsers = User::query()->with('activities');

		// --
		// Search users by user ID
		if ($request->has('search')) {
			$searchTerm = $request->input('search');
			$allUsers->where('id', $searchTerm);
		}

		// --
		// Filter users based on selected filter[day/month/year]
		$allUsers->when($filter === 'day', function ($query) {
			return $query->whereHas('activities', function ($q) {
				$q->whereDate('activity_date', today());
			});
		})
			->when($filter === 'month', function ($query) {
				return $query->whereHas('activities', function ($q) {
					$q->whereMonth('activity_date', now()->month);
				});
			})
			->when($filter === 'year', function ($query) {
				return $query->whereHas('activities', function ($q) {
					$q->whereYear('activity_date', now()->year);
				});
			});

		// --
		// Get all users and their activities
		$users = $allUsers->get();

		// --
		// Recalculate points when insert new records
		if ($request->has('recalculate')) {
			$users = $this->getRecalculatePoints($users);
		}

		// --
		// Sort users by most points
		$users = $users->sortByDesc('total_points')->values();

		return view('leaderboard.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}

	/**
	 * Recalculate the points based on activities.
	 */
	public function getRecalculatePoints($users)
	{
		foreach ($users as $user) {
			// --
			// Calculate total points on activities
			$totalPoints = $user->activities()->sum('points');
			$user->update(['total_points' => $totalPoints]);

			// --
			// Calculate rank based on points
			$user->rank = User::where('total_points', '>', $totalPoints)->count() + 1;
			$user->save();
		}

		return User::with('activities')->get();
	}
}
