@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => __('pages.languages.label'),
        'items' => [
            [ 'name' => __('pages.languages.label'), 'link' => null ]
        ]
    ]
])

@section('content')
    <div class="row">
        <div class="col-12">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all mr-2"></i>
                    {{ Session::get('success') }}
                </div>
            @endif
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8 offset-sm-4">
                            <div class="text-sm-right">
                                <a href="#" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target=".car-de-modal">
                                    <i class="mdi mdi-plus mr-1"></i> {{ __('form.buttons.add') }}
                                </a>
                            </div>
                        </div>
                    </div>
        
                    @if ($langs->count() === 0)
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <i class="mdi mdi-information mr-2"></i>
                            {{ __('pages.languages.emptySet') }}
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 70px;">#</th>
                                        <th scope="col">{{ __('pages.languages.label') }}</th>
                                        <th scope="col">{{ __('pages.languages.codeLabel') }}</th>
                                        <th scope="col">{{ __('pages.languages.actionsLabel') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($langs as $idx => $lang)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $lang->name }}</td>
                                            <td>{{ $lang->code }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="#" data-id="{{ $lang->id }}" class="edit-btn" title="{{ __('form.buttons.edit') }}"><i class="bx bx-pencil"></i></a>
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
                            {{ $langs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('languages.modals.create')
    @include('languages.modals.edit')
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            var editLangModal = $('.edit-lang-modal');
            var langId = null;

            $('.edit-btn').click(function(e) {
                e.preventDefault();
                let editBtn = $(this);
                langId = editBtn.data('id');
                let loadingIcon = '<i class="bx bx-loader bx-spin font-size-16 align-middle mr-2"></i>';
                let pencilIcon = '<i class="bx bx-pencil"></i>';

                editBtn.html(loadingIcon);

                $.ajax({
                    url: '/languages/getById/' + langId,
                    type: 'GET',
                    success: function(lang) {
                        editLangModal.find('form').attr('action', `languages/${langId}`);
                        editLangModal.find('form').find('input#nameRu').val(lang.name.ru);
                        editLangModal.find('form').find('input#nameEn').val(lang.name.en);
                        editLangModal.find('form').find('input#code').val(lang.code);

                        // Show the modal
                        editLangModal.modal('show');
                        
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