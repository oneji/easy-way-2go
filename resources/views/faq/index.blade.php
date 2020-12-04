@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <h5 class="mt-0 mb-0 col-6 d-flex align-items-center">
                        <i class="mdi mdi-alert-circle-outline mr-3"></i> {{ __('pages.faq.label') }}
                    </h5>

                    <div class="col-6">
                        <a href="{{ route('admin.faq.create') }}" class="btn btn-success btn-rounded waves-effect waves-light float-right">
                            <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                        </a>
                    </div>
                </div>

                @if ($data->count() > 0)
                    <div id="accordion">
                        @foreach ($data as $item)
                            <div class="card mb-1 shadow-none">
                                <div class="card-header" id="heading-{{ $item->id }}">
                                    <h6 class="m-0 d-flex align-items-center justify-content-between">
                                        <a href="#collapse-{{ $item->id }}" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="collapse-{{ $item->id }}">
                                            {{ $item->title }}
                                        </a>

                                        <div class="actions-btns">
                                            <a href="{{ route('admin.faq.edit', [$item->id]) }}" class="btn btn-success btn-sm mr-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('deleteForm{{ $item->id }}').submit();" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                            <form action="{{ route('admin.faq.delete', [$item->id]) }}" method="POST" id="deleteForm{{ $item->id }}" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </h6>
                                </div>

                                <div id="collapse-{{ $item->id }}" class="collapse collapsed" aria-labelledby="heading-{{ $item->id }}" data-parent="#accordion">
                                    <div class="card-body">
                                        {!! $item->full_description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        {{ __('pages.faq.emptySet') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection