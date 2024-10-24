@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="row">
            <!-- Search Bar -->
            <div class="col-sm-5">
                <form method="GET" action="{{ route('leaderboard.index') }}">
                    <div class="form-group d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Search by User ID">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>

            <!-- Filter by day, month, year -->
            <div class="col-sm-3">
                <form method="GET" action="{{ route('leaderboard.index') }}">
                    <div class="form-group">
                        <select name="filter" onchange="this.form.submit()" class="form-control">
                            <option value="all">All</option>
                            <option value="day">Today</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Recalculate Button -->
            <div class="col-sm-4">
                <form method="POST" action="{{ route('leaderboard.index') }}">
                    <div class="form-group d-flex">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Recalculate Points</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Leaderboard Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Points</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->total_points }}</td>
                        <td>{{ $user->rank }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection