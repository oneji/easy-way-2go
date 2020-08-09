<div class="modal fade car-model-modal" tabindex="-1" role="dialog" aria-labelledby="carModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Добавить модель траспорта</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.carModels.store') }}" method="POST" class="form-horizontal custom-validation" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Название модели</label>
                                <input name="name" type="text" class="form-control" placeholder="Введите название" required>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Модель</label>
                                <select name="car_brand_id" class="form-control">
                                    @foreach ($carBrands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block waves-effect waves-light">Добавить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>