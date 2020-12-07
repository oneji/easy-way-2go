@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <h5 class="mt-0 mb-0 col-6 d-flex align-items-center">
                        <i class="mdi mdi-alert-circle-outline mr-3"></i> {{ __('pages.help.label') }}
                    </h5>

                    <div class="col-6">
                        <a href="{{ route('admin.helpItems.create') }}" class="btn btn-info btn-rounded waves-effect waves-light mb-2 mr-2 float-right">
                            <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                        </a>

                        <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2 float-right" data-toggle="modal" data-target=".help-modal">
                            <i class="mdi mdi-plus mr-1"></i> {{ __('pages.help.addSectionBtn') }}
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
                                            {{ $item->name }}
                                        </a>

                                        <div class="actions-btns">
                                            <a href="#" class="btn btn-success btn-sm mr-1 edit-btn" data-id="{{ $item->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('deleteForm{{ $item->id }}').submit();" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                            <form action="{{ route('admin.help.delete', [$item->id]) }}" method="POST" id="deleteForm{{ $item->id }}" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </h6>
                                </div>

                                <div id="collapse-{{ $item->id }}" class="collapse collapsed" aria-labelledby="heading-{{ $item->id }}" data-parent="#accordion">
                                    <div class="card-body">
                                        <div id="accordion2">
                                            @foreach ($item->items as $helpItem)
                                                <div class="card mb-1 shadow-none">
                                                    <div class="card-header" id="heading-{{ $helpItem->id }}">
                                                        <h6 class="m-0 d-flex align-items-center justify-content-between">
                                                            <a href="#helpItem-{{ $helpItem->id }}" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="helpItem-{{ $helpItem->id }}">
                                                                {{ $helpItem->title }}
                                                            </a>
                    
                                                            <div class="actions-btns">
                                                                <a href="{{ route('admin.helpItems.edit', [$helpItem->id]) }}" class="btn btn-success btn-sm mr-1">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                                
                                                                <a href="#" onclick="event.preventDefault(); document.getElementById('deleteHelpItemForm{{ $helpItem->id }}').submit();" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                    
                                                                <form action="{{ route('admin.help.delete', [$helpItem->id]) }}" method="POST" id="deleteHelpItemForm{{ $helpItem->id }}" class="hidden">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </h6>
                                                    </div>
                    
                                                    <div id="helpItem-{{ $helpItem->id }}" class="collapse collapsed" aria-labelledby="heading-{{ $helpItem->id }}" data-parent="#accordion2">
                                                        <div class="card-body">
                                                            {!! $helpItem->description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-information mr-2"></i>
                        {{ __('pages.help.emptySet') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('help.modals.create')
    @include('help.modals.edit')
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                const editBtn = $(this);
                const editHelpModal = $('.edit-help-modal');
                const sectionId = editBtn.data('id');

                const loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
                const pencilIcon = '<i class="bx bx-pencil"></i>';
                
                editBtn.html(loadingIcon);

                // Make the AJAX request
                $.ajax({
                    url: '/help/getById/' + sectionId,
                    type: 'GET',
                    success: function(section) {
                        for (const langCode in section.name) {
                            editHelpModal.find('form').find(`input[data-lang=${langCode}]`).val(section.name[langCode]);
                        }

                        editHelpModal.find('form').attr('action', `help/${sectionId}`);

                        // Show the modal
                        editHelpModal.modal('show');
                        editBtn.html(pencilIcon);
                    },
                    error: function(err) {
                        console.log('err', err);
                    }
                });
                
                
            });
        });
    </script>
@endsection