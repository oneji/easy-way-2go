@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.bas.label'),
        'items' => [
            [ 'name' => __('pages.bas.label'), 'link' => null ],
        ]
    ]
])

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mdi mdi-check-all mr-2"></i>
                {{ Session::get('success') }}
            </div>
        @endif
        
        <div class="card">
            <div class="card-body">
                @if ($baRequests->count() === 0)
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        {{ __('pages.bas.emptySet') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px;">#</th>
                                    <th scope="col">{{ __('pages.bas.datatable.request') }}</th>
                                    <th scope="col">{{ __('pages.bas.datatable.type') }}</th>
                                    <th scope="col">{{ __('pages.bas.datatable.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($baRequests as $idx => $baRequest)
                                    <tr>
                                        <th>{{ $idx + 1 }}</th>
                                        <td>{{ __('pages.bas.datatable.request') .' №'. $baRequest->id }}</td>
                                        <td>
                                            @if ($baRequest->type === 'firm_owner')
                                                <span class="badge badge-success font-size-12">Собственник фирмы</span>
                                            @else
                                                <span class="badge badge-primary font-size-12">Главный водитель</span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="#" class="{{ $baRequest->type === 'firm_owner' ? 'firm-owner-info-btn' : 'main-driver-info-btn' }}" data-id="{{ $baRequest->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('form.buttons.view') }}"><i class="bx bx-info-circle"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        {{ $baRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('bas.modals.firm-owner-info')
@include('bas.modals.main-driver-info')
@endsection

@section('scripts')
    @parent
    
    <script src="{{ asset('assets/js/custom/bas.js') }}"></script>
@endsection