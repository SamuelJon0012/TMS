@extends(config('laravelusers.laravelUsersBladeExtended'))

@section('template_title')
    {!! trans('laravelusers::laravelusers.showing-all-users') !!}
@endsection

@section('template_linked_css')
    @if(config('laravelusers.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('laravelusers.datatablesCssCDN') }}">
    @endif
    @if(config('laravelusers.fontAwesomeEnabled'))
        <link rel="stylesheet" type="text/css" href="{{ config('laravelusers.fontAwesomeCdn') }}">
    @endif
    @include('laravelusers::partials.styles')
    @include('laravelusers::partials.bs-visibility-css')
@endsection

@section('content')
    @admin
    <div class="container">
        @if(config('laravelusers.enablePackageBootstapAlerts'))
            <div class="row">
                <div class="col-sm-12">
                    @include('laravelusers::partials.form-status')
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {!! trans('laravelusers::laravelusers.showing-all-users') !!}
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                @if(config('laravelusers.softDeletedEnabled'))
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">
                                            {!! trans('laravelusers::laravelusers.users-menu-alt') !!}
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('users.create') }}">
                                                @if(config('laravelusers.fontAwesomeEnabled'))
                                                    <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                                @endif
                                                {!! trans('laravelusers::laravelusers.buttons.create-new') !!}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/users/deleted">
                                                @if(config('laravelusers.fontAwesomeEnabled'))
                                                    <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                                @endif
                                                {!! trans('laravelusers::laravelusers.show-deleted-users') !!}
                                            </a>
                                        </li>
                                    </ul>
                                @else
                                    <a href="{{ route('users.create') }}" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement="left" title="{!! trans('laravelusers::laravelusers.tooltips.create-new') !!}">
                                        @if(config('laravelusers.fontAwesomeEnabled'))
                                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        @endif
                                        {!! trans('laravelusers::laravelusers.buttons.create-new') !!}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        @if(config('laravelusers.enableSearchUsers'))
                            @include('laravelusers::partials.search-users-form')
                        @endif

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {!! trans_choice('laravelusers::laravelusers.users-table.caption', 1, ['userscount' => $users->count()]) !!}
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th>{!! trans('laravelusers::laravelusers.users-table.id') !!}</th>
                                        <th>{!! trans('laravelusers::laravelusers.users-table.name') !!}</th>
                                        <th class="hidden-xs">{!! trans('laravelusers::laravelusers.users-table.email') !!}</th>
                                        @if(config('laravelusers.rolesEnabled'))
                                            <th class="hidden-sm hidden-xs">{!! trans('laravelusers::laravelusers.users-table.role') !!}</th>
                                        @endif
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('laravelusers::laravelusers.users-table.created') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('laravelusers::laravelusers.users-table.updated') !!}</th>
                                        <th class="no-search no-sort">{!! trans('laravelusers::laravelusers.users-table.actions') !!}</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td class="hidden-xs">{{$user->email}}</td>
                                            @if(config('laravelusers.rolesEnabled'))
                                                <td class="hidden-sm hidden-xs">
                                                    @foreach ($user->roles as $user_role)
                                                        @if ($user_role->name == 'User')
                                                            @php $badgeClass = 'primary' @endphp
                                                        @elseif ($user_role->name == 'Admin')
                                                            @php $badgeClass = 'warning' @endphp
                                                        @elseif ($user_role->name == 'Unverified')
                                                            @php $badgeClass = 'danger' @endphp
                                                        @else
                                                            @php $badgeClass = 'dark' @endphp
                                                        @endif
                                                        <span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span>
                                                    @endforeach
                                                </td>
                                            @endif
                                            <td class="hidden-sm hidden-xs hidden-md">{{$user->created_at}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$user->updated_at}}</td>
                                            <td>
                                                {!! Form::open(array('url' => 'users/' . $user->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => trans('laravelusers::laravelusers.tooltips.delete'))) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button(trans('laravelusers::laravelusers.buttons.delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('laravelusers::modals.delete_user_title'), 'data-message' => trans('laravelusers::modals.delete_user_message', ['user' => $user->name]))) !!}
                                                {!! Form::close() !!}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('users/' . $user->id) }}" data-toggle="tooltip" title="{!! trans('laravelusers::laravelusers.tooltips.show') !!}">
                                                    {!! trans('laravelusers::laravelusers.buttons.show') !!}
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('users/' . $user->id . '/edit') }}" data-toggle="tooltip" title="{!! trans('laravelusers::laravelusers.tooltips.edit') !!}">
                                                    {!! trans('laravelusers::laravelusers.buttons.edit') !!}
                                                </a>
                                            </td>
                                            <td>
                                                @if($user->is_patient && $user->is_confirmed == 0)
                                                    <a class="btn btn-sm btn-secondary btn-block" href="#"  type="button" data-toggle="modal" data-target="#exampleModal" onclick="openConfirmedModal({{$user}})">
                                                        {!! trans('laravelusers::laravelusers.buttons.confirm-user') !!}
                                                    </a>
                                                 @elseif($user->is_patient && $user->is_confirmed == 1)
                                                    <button class="btn btn-sm btn-secondary btn-block" disabled>
                                                        {!! trans('laravelusers::laravelusers.buttons.confirmed') !!}
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                @if(config('laravelusers.enableSearchUsers'))
                                    <tbody id="search_results"></tbody>
                                @endif
                            </table>

                            @if($pagintaionEnabled)
                                {{ $users->links() }}
                            @endif

                        </div>
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="max-width: 880px">
                            <div class="modal-content" style="padding: 20px;">
                                <div class="modal-header text-center" style="border-bottom: 0px">
                                    <h5 class="modal-title w-100" id="exampleModalLabel">{{ __('Patient Confirmation') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-6 pl-4">
                                        <a style="cursor: pointer;"><i class="fas fa-arrow-left" style="font-size: 12px;"></i> {{ __('Home') }}  </a>
                                        <a class="ml-2" style="cursor: pointer;"><i class="fas fa-arrow-left"style="font-size: 12px;"></i>{{ __('Search') }}</a>
                                    </div>
                                </div>
                                <div class="modal-body mt-2"style="border-top: 1px solid #dee2e6;">
                                    <div class="row">
                                        <div class="col-6 col_left_right">
                                            <div class="rounded_div">
                                                <div class="personal_rounded">
                                                    <p class="personal_rounded_p">{{ __('Personal Data') }}</p>
                                                    <p class="mt-3 mb-3" style="padding: 0px 14px;">{{ __('Please confirm identity of yourvisitor and the information on this page, then praceed to the next step.') }}</p>
                                                    <p class="p_left"><strong>{{ __('First Name') }} </strong></p><p class="p_right first_name">{{ __('First Name') }}</p>
                                                    <p class="p_left"><strong>{{ __('Last Name') }} </strong></p><p class="p_right last_name">{{ __('Last Name') }}</p>
                                                    <p class="p_left"><strong>{{ __('Date of Birth') }} </strong></p><p class="p_right date_of_birth">{{ __('Date of Birth') }}</p>
                                                    <p class="p_left"><strong>{{ __('SSN') }} </strong></p><p class="p_right ssn">{{ __('SSN') }}</p>
                                                    <p class="p_left"><strong>{{ __('Driver`s License') }} </strong></p><p class="p_right drivers_license">{{ __('Driver`s License') }}</p>
                                                    <p class="p_left"><strong>{{ __('Address') }} </strong></p><p class="p_right address">{{ __('Address') }}</p>
                                                    <p class="p_left"><strong>{{ __('Apt / Unie') }} </strong></p><p class="p_right apt_unit">{{ __('Apt / Unie') }}</p>
                                                    <p class="p_left"><strong>{{ __('City') }} </strong></p><p class="p_right city">{{ __('City') }}</p>
                                                    <p class="p_left"><strong>{{ __('State') }} </strong></p><p class="p_right state">{{ __('State') }}</p>
                                                    <p class="p_left" style="margin-bottom: 15px;"><strong>{{ __('Zipconde') }} </strong></p><p class="p_right zipcode">{{ __('Zipconde') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col_left_right">
                                            <div class="rounded_div">
                                                <div class="personal_rounded">
                                                    <p class="personal_rounded_p">{{ __('Demographics') }}</p>
                                                    <p class="p_left"><strong>{{ __('Email') }} </strong></p><p class="p_right email">{{ __('Email') }}</p>
                                                    <p class="p_left"><strong>{{ __('Mobile Phone') }} </strong></p><p class="p_right mobile_phone">{{ __('Mobile Phone') }}</p>
                                                    <p class="p_left"><strong>{{ __('Home Phone') }} </strong></p><p class="p_right home_phone">{{ __('Home Phone') }}</p>
                                                    <p class="p_left"><strong>{{ __('Birth Sex') }} </strong></p><p class="p_right birth_sex">{{ __('Birth Sex') }}</p>
                                                    <p class="p_left"><strong>{{ __('Race') }} </strong></p><p class="p_right race">{{ __('Race') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="justify-content:center;">
                                    <form id="logout-form" action="{{ route('confirm-patient') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" id="user_id">
                                        <button type="submit" class="btn btn-primary">Confirm Patient</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('laravelusers::modals.modal-delete')
@endadmin
@endsection

@section('template_scripts')
    @if ((count($users) > config('laravelusers.datatablesJsStartCount')) && config('laravelusers.enabledDatatablesJs'))
        @include('laravelusers::scripts.datatables')
    @endif
    @include('laravelusers::scripts.delete-modal-script')
    @include('laravelusers::scripts.confirmed-modal')
    @include('laravelusers::scripts.save-modal-script')
    @if(config('laravelusers.tooltipsEnabled'))
        @include('laravelusers::scripts.tooltips')
    @endif
    @if(config('laravelusers.enableSearchUsers'))
        @include('laravelusers::scripts.search-users')
    @endif

@endsection
