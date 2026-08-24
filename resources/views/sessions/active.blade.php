@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-4">Active Sessions</h1>
        </div>
        <div class="col-md-4 text-right">
            @if($sessions->count() > 1)
                <form method="POST" action="{{ route('logout-other-sessions') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">Logout All Other Sessions</button>
                </form>
            @endif
        </div>
    </div>

    @if($sessions->isEmpty())
        <div class="alert alert-info">
            No active sessions found.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Device</th>
                    <th>IP Address</th>
                    <th>Login Time</th>
                    <th>Last Activity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->device_name }}</td>
                        <td>{{ $session->ip_address }}</td>
                        <td>{{ $session->login_at->format('M d, Y H:i A') }}</td>
                        <td>
                            @if($session->last_activity_at)
                                {{ $session->last_activity_at->format('M d, Y H:i A') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($session->user_agent === request()->userAgent())
                                <span class="badge badge-primary">Current Device</span>
                            @else
                                <form method="POST" action="{{ route('logout-session', $session->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
