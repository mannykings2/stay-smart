@extends('layouts.app', [$activePage = 'Roles'])

@section('content')
<!-- Row -->
@include('modals.add-role')
@include('modals.edit-role')
@include('modals.delete-role')
<main class="page-content">
    <div class="container">
        <div class="row">
            @can('create roles')
            <div class="col-sm-12 mb-4 d-flex justify-content-end">
                <button class="btn btn-dark px-5" onclick="addRole();" role="button">
                    <i class="bx bx-plus"></i> Create Role
                </button>
            </div>
            @endcan
            <div class="col-md-12">
                <div class="card shadow-sm p-3">
                    <table class="table mDatatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Role Name</th>
                                <th>Guard</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Role Name</th>
                                <th>Guard</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody style="font-size: 12px">
                            @if ($roles)
                                @foreach ($roles as $key => $role)
                                    @php
                                        $createdAt = $role->created_at;
                                        $formattedDate = ($createdAt->isToday()) ? 'Today' : (($createdAt->isYesterday()) ? 'Yesterday' : $createdAt->format('M d'));
                                        $formattedDateTime = $createdAt->format('h:i A');
                                    @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$role->name}}</td>
                                        <td>{{$role->guard_name}}</td>
                                        <td style="font-size: 11px;">{{$formattedDate}}, {{$formattedDateTime}}</td>
                                        <td class="action-btn">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-sm btn-dark" onclick="editRole({{$role->id}}, '{{$role->name}}')">
                                                    <i class='bx bx-pencil ms-0'></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteRole({{$role->id}})">
                                                    <i class='bx bx-trash ms-0'></i>
                                                </button>
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
<!-- /Row -->
@endsection
