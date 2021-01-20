<div class="row">
    @foreach ($drivers as $driver)
        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="card text-center">
                <div class="card-body">
                    @if ($driver->photo)
                        <div class="mb-4">
                            <img class="rounded-circle avatar-sm" src="{{ asset('storage/'.$driver->photo) }}" alt="">
                        </div>
                    @else
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                {{ substr($driver->first_name, 0, 1) .''.substr($driver->last_name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    
                    <h5 class="font-size-15"><a href="#" class="text-dark">{{ $driver->first_name .' '. $driver->last_name }}</a></h5>
                    <p class="text-muted mb-0">{{ $driver->email }}</p>
                    <p class="text-muted">{{ $driver->phone_number }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>