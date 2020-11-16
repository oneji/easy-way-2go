@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.bas.label'),
        'items' => [
            [ 'name' => __('pages.bas.label'), 'link' => null ],
        ]
    ]
])

@section('head')
    @parent

    <!-- Lightbox css -->
    <link href="{{ asset('assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .car-image-wrapper {
            display: inline-block;
            position: relative;
        }

        .car-image-wrapper > .car-image-delete-btn {
            font-size: 18px;
            color: #ddd;
            transition: .3s all ease;
            position: absolute;
            top: 0;
            right: 5px;
            opacity: 0;
        }

        .car-image-wrapper > .car-image-delete-btn:hover {
            color: #f46a6a;
        }

        .car-image {
            width: 70px;
            border: 1px solid #ddd;
            padding: 3px;
            margin: 5px;
            border-radius: 100%;
            height: 70px;
            transition: .3s all ease;
        }

        .car-image:hover {
            border: 1px solid #34c38f;
        }

        .car-image-wrapper:hover .car-image-delete-btn {
            opacity: 1;
        }

        .mfp-wrap {
            z-index: 99999;
        }
    </style>
@endsection

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
                                    <th scope="col">{{ __('pages.bas.datatable.status') }}</th>
                                    <th scope="col">{{ __('pages.bas.datatable.date') }}</th>
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
                                                <span class="badge badge-success font-size-12">{{ __('pages.bas.firmOwner.label') }}</span>
                                            @else
                                                <span class="badge badge-primary font-size-12">{{ __('pages.bas.mainDriver.label') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($baRequest->status === 'approved')
                                                <span class="badge badge-success font-size-12">{{ __('pages.bas.datatable.statusApproved') }}</span>
                                            @elseif ($baRequest->status === 'pending')
                                                <span class="badge badge-info font-size-12">{{ __('pages.bas.datatable.statusPending') }}</span>
                                            @elseif ($baRequest->status === 'declined')
                                                <span class="badge badge-danger font-size-12">{{ __('pages.bas.datatable.statusDeclined') }}</span>
                                            @endif
                                        <td>
                                            {{ \Carbon\Carbon::parse($baRequest->created_at)->translatedFormat('F d, Y') }}
                                        </td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ route('admin.bas.show', [$baRequest->id]) }}" data-id="{{ $baRequest->id }}"><i class="bx bx-info-circle"></i></a>
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
@endsection

@section('scripts')
    @parent
    
    <script src="{{ asset('assets/js/custom/bas.js') }}"></script>
    <script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
@endsection