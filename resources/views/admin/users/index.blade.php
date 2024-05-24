@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')
  
<form action="{{ route('admin.users')}}" method="get">
    <input type="search" name="search" value="{{ $search }}" placeholder="search names" class="form-control form-control-sm mb-3 ms-auto" style="width:10rem">
</form>

  <table class="table border table-hover bg-white align-middle text-secondary">
    <thead class="text-secondary table-success text-uppercase small">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($all_users as $user)
            <tr>
                <td>
                    {{-- avatar/icon --}}
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md d-block mx-auto">
                    @else 
                        <i class="fa-solid fa-circle-user icon-md d-block text-secondary text-center"></i>
                    @endif 
                </td>
                <td>
                    {{-- user name --}}
                    <a href="{{ route('profile.show', $user->id)}}" class="text-decoration-none fw-bold text-dark">
                        {{ $user->name }}
                    </a>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    {{-- status --}}
                    @if($user->trashed())
                        <i class="fa-regular fa-circle"></i> Inactive
                    @else 
                        <i class="fa-solid fa-circle text-success"></i> Active
                    @endif 
                </td>
                <td>
                    @if($user->id != Auth::user()->id)
                    <div class="dropdown">
                        <button class="btn btn-sm" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        @if(!$user->trashed())
                            <div class="dropdown-menu">
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user{{ $user->id }}">
                                    <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                                </button>
                            </div>
                        @else 
                            <div class="dropdown-menu">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user{{ $user->id }}">
                                    <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                                </button>
                            </div>
                        @endif

                        @include('admin.users.actions')
                    </div>
                    @endif
                </td>
            </tr>
        @empty 
            <tr>
                <td class="text-center" colspan="6">No users found.</td>
            </tr>
        @endforelse 
    </tbody>
  </table>
  {{ $all_users->links() }}

@endsection