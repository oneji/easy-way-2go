@extends('layouts.app')

@section('head')
    @parent

    <link href="{{ asset('assets/libs/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <form method="POST" action="{{ route('admin.faq.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    <h4 class="card-title">{{ __('pages.faq.createFormLabel') }}</h4>
                    <p class="card-title-desc"></p>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                        @foreach ($langs as $idx => $lang)
                            <li class="nav-item">
                                <a class="nav-link {{ $idx === 0 ? 'active' : null }}" data-toggle="tab" href="#{{ $lang->code }}" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{ $lang->name }}</span> 
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        @foreach ($langs as $idx => $lang)
                            <div class="tab-pane {{ $idx === 0 ? 'active' : null }}" id="{{ $lang->code }}" role="tabpanel">
                                <p class="mb-0">
                                    <div class="form-group">
                                        <label>{{ __('form.labels.title') }}</label>
                                        <input type="text" name="title[{{ $lang->code }}]" class="form-control" placeholder="{{ __('form.placeholders.title') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('form.labels.description') }}</label>
                                        <textarea name="description[{{ $lang->code }}]" cols="30" rows="5" class="form-control" placeholder="{{ __('form.placeholders.description') }}"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('form.labels.fullDescription') }}</label>
                                        <textarea name="full_description[{{ $lang->code }}]" cols="30" rows="5" class="form-control summernote" id="summernote_{{ $lang->code }}" placeholder="{{ __('form.placeholders.fullDescription') }}"></textarea>
                                    </div>
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success" type="submit">{{ __('form.buttons.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // File manager button (image icon)
            const FMButton = function (context) {
                const ui = $.summernote.ui;
                const button = ui.button({
                    contents: '<i class="note-icon-picture"></i> ',
                    tooltip: 'File Manager',
                    click: function () {
                        window.open('/file-manager/summernote', 'fm', 'width=1400,height=800');
                    }
                });
                return button.render();
            };
            $('textarea.summernote').each(function() {
                $(this).summernote({
                    height: 300,
                    toolbar: [
                        // [groupName, [list of button]]
                        [
                            'style', [ 
                                'bold',
                                'italic',
                                'underline',
                                'clear' 
                            ] 
                        ],
                        [
                            'font', [
                                'strikethrough',
                                'superscript',
                                'subscript' 
                            ] 
                        ],
                        [ 
                            'font', [
                                'fontsize'
                            ] 
                        ],
                        [
                            'color', [ 
                                'color' 
                            ] 
                        ],
                        [
                            'para', [ 
                                'ul',
                                'ol',
                                'paragraph'
                            ]
                        ],
                        [
                            'height', [
                                'height'
                            ]
                        ],
                        [
                            'insert', [
                                'link',
                                'video',
                                'table',
                                'hr'
                            ]
                        ],
                        [ 'fm-button', [ 'fm' ] ],
                    ],
                    buttons: {
                        fm: FMButton
                    }
                });
            })
        });

        // set file link
        function fmSetLink(url) {
            $('.summernote').summernote('insertImage', url);
        }
      </script>
@endsection