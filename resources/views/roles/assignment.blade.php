@extends('layouts.app', [$activePage = 'Assign Role'])

@section('content')
<!-- Row -->
@include('modals.assign-role', ['roles' => $roles])
<main class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm p-3">
                    <h5 class="text-kdis-2 subheader">Roles</h5>
                    <table class="table mDatatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody style="font-size: 12px">
                            @if ($users)
                                @foreach ($users as $key => $user)
                                    @php
                                        $createdAt = $user->created_at;
                                        $formattedDate = ($createdAt->isToday()) ? 'Today' : (($createdAt->isYesterday()) ? 'Yesterday' : $createdAt->format('M d'));
                                        $formattedDateTime = $createdAt->format('h:i A');
                                    @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach($user->getRoleNames() as $key => $val)
                                                <span>{{$val}}</span>
                                            @endforeach
                                        </td>
                                        <td style="font-size: 11px;">{{$formattedDate}}, {{$formattedDateTime}}</td>
                                        <td class="action-btn">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a class="btn btn-dark btn-sm" href="javascript:void(0);" onclick="viewAssignRole({{$user->id}}, '{{$user->email}}', '{{count($user->getRoleNames())>0 ? $user->getRoleNames()[0] : ''}}')" role="button">
                                                    <i class="bx bx-plus ms-0"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
