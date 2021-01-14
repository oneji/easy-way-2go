@extends('layouts.app')

@section('head')
    @parent

    <style>
        .box-shadow {
            box-shadow: 0 2px 1px -1px rgba(0,0,0,.2),0 1px 1px 0 rgba(0,0,0,.14),0 1px 3px 0 rgba(0,0,0,.12)!important;
        }
    </style>
@endsection

@section('content')
<div class="d-lg-flex">
    <div class="chat-leftsidebar mr-lg-4">
        <div>
            <chat-header
                name="{{ Auth::user()->name }}"
                photo="{{ asset('assets/images/users/no-photo.png') }}"
            ></chat-header>

            {{-- <chat-search-input></chat-search-input> --}}

            <div class="chat-leftsidebar-nav py-4">
                <div>
                    <h5 class="font-size-14 mb-3">Недавние</h5>
                    <contacts-list></contacts-list>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 user-chat">
        <div class="card box-shadow">
            <div class="py-3 px-4 border-bottom ">
                <div class="row">
                    <div class="col-md-4 col-9">
                        <h5 class="font-size-15 mb-1">Steven Franklin</h5>
                        <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle mr-1"></i> Active now</p>
                    </div>
                </div>
            </div>


            <div>
                <div class="chat-conversation p-3">
                    <ul class="list-unstyled" data-simplebar style="max-height: 470px;">
                        <li> 
                            <div class="chat-day-title">
                                <span class="title">Today</span>
                            </div>
                        </li>
                        <li>
                            <div class="conversation-list">
                                <div class="dropdown">

                                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Copy</a>
                                        <a class="dropdown-item" href="#">Save</a>
                                        <a class="dropdown-item" href="#">Forward</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                                <div class="ctext-wrap">
                                    <div class="conversation-name">Steven Franklin</div>
                                    <p>
                                        Hello!
                                    </p>
                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 10:00</p>
                                </div>
                                
                            </div>
                        </li>

                        <li class="right">
                            <div class="conversation-list">
                                <div class="dropdown">

                                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Copy</a>
                                        <a class="dropdown-item" href="#">Save</a>
                                        <a class="dropdown-item" href="#">Forward</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                                <div class="ctext-wrap">
                                    <div class="conversation-name">Henry Wells</div>
                                    <p>
                                        Hi, How are you? What about our next meeting?
                                    </p>

                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 10:02</p>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="conversation-list">
                                <div class="dropdown">

                                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Copy</a>
                                        <a class="dropdown-item" href="#">Save</a>
                                        <a class="dropdown-item" href="#">Forward</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                                <div class="ctext-wrap">
                                    <div class="conversation-name">Steven Franklin</div>
                                    <p>
                                        Yeah everything is fine
                                    </p>
                                    
                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 10:06</p>
                                </div>
                                
                            </div>
                        </li>

                        <li class="last-chat">
                            <div class="conversation-list">
                                <div class="dropdown">

                                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Copy</a>
                                        <a class="dropdown-item" href="#">Save</a>
                                        <a class="dropdown-item" href="#">Forward</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                                <div class="ctext-wrap">
                                    <div class="conversation-name">Steven Franklin</div>
                                    <p>& Next meeting tomorrow 10.00AM</p>
                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 10:06</p>
                                </div>
                                
                            </div>
                        </li>

                        <li class=" right">
                            <div class="conversation-list">
                                <div class="dropdown">

                                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                      </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Copy</a>
                                        <a class="dropdown-item" href="#">Save</a>
                                        <a class="dropdown-item" href="#">Forward</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                                <div class="ctext-wrap">
                                    <div class="conversation-name">Henry Wells</div>
                                    <p>
                                        Wow that's great
                                    </p>

                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 10:07</p>
                                </div>
                            </div>
                        </li>
                        
                        
                    </ul>
                </div>
                <div class="p-3 chat-input-section">
                    <div class="row">
                        <div class="col">
                            <div class="position-relative">
                                <input type="text" class="form-control chat-input" placeholder="Enter Message...">
                                <div class="chat-input-links">
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Emoji"><i class="mdi mdi-emoticon-happy-outline"></i></a></li>
                                        <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Images"><i class="mdi mdi-file-image-outline"></i></a></li>
                                        <li class="list-inline-item"><a href="#" data-toggle="tooltip" data-placement="top" title="Add Files"><i class="mdi mdi-file-document-outline"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block mr-2">Send</span> <i class="mdi mdi-send"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end row -->
@endsection