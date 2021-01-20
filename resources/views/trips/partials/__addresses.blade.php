<div class="row mb-4" style="font-size: 110%">
    <div class="col-sm-4">
        <p class="mb-1"><strong>{{ $departure_time }}</strong> {{ \Carbon\Carbon::parse($departure_date)->format('d.m.y') }}</p>
        <p>{{ $departure_from }}</p>
    </div>
    <div class="col-sm-4 d-flex align-items-center justify-content-center">
        ____________________
    </div>
    <div class="col-sm-4 text-right">
        <p class="mb-1"><strong>{{ $arrival_time }}</strong> {{ \Carbon\Carbon::parse($arrival_date)->format('d.m.y') }}</p>
        <p>{{ $arrival_to }}</p>
    </div>
</div>