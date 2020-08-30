@extends('layouts.app', [
    'breadcrumbs' => [
        'title' => 'Водительский опыт',
        'items' => [
            [ 'name' => 'Водительский опыт', 'link' => null ]
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
                                    <i class="mdi mdi-plus mr-1"></i> Добавить водительский опыт
                                </a>
                            </div>
                        </div>
                    </div>
        
                    @if ($deList->count() === 0)
                        <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                            <i class="mdi mdi-information mr-2"></i>
                            На данный момент записей о водительском опыте не найдено.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 70px;">#</th>
                                        <th scope="col">Водительский опыт</th>
                                        <th scope="col">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deList as $idx => $item)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="#" data-id="{{ $item->id }}" class="edit-btn" data-toggle="tooltip" data-placement="top" title="Изменить"><i class="bx bx-pencil"></i></a>
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
                            {{ $deList->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('driving-experience.partials._create-de-modal')
    @include('driving-experience.partials._edit-de-modal')
@endsection

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            var editDeModal = $('.edit-de-modal');
            var editLoading = $('.loading-block');
            var deId = null;

            $('.edit-btn').click(function(e) {
                e.preventDefault();
                deId = $(this).data('id');
                // Show the modal
                editDeModal.modal('show');
            });

            editDeModal.on('shown.bs.modal', function() {
                editLoading.css('display', 'flex');

                // Make the AJAX request
                $.ajax({
                    url: '/driving-experience/getById/' + deId,
                    type: 'GET',
                    success: function(data) {
                        editDeModal.find('form').attr('action', `/driving-experience/${deId}`);
                        editDeModal.find('form').find('input[name=name]').val(data.deItem.name)
                    },
                    error: function(err) {
                        console.log('err', err);
                    }
                }); 
            });
        });
    </script>
@endsection