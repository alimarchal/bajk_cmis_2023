<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="form-row">

        <div class="col-md-3 mb-3">
            <label for="region" title="4"><strong>Region</strong></label>
            <select class="custom-select" title="4" id="region" name="region" wire:change="region($event.target.value)">
                <option value="">None</option>
                @foreach ($regions as $region)
                    <option value="{{strtoupper($region)}}">{{strtoupper($region)}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Please choose a branch.
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="zone" title="3"><strong>Zone</strong></label>
            <select class="custom-select" id="zone" name="zone"  wire:change="zone($event.target.value)">
                <option value="" selected>None</option>
                @if (!empty($regionValue))
                    @foreach ($regionValue as $region)
                        <option value="{{strtoupper($region->zone)}}">{{strtoupper($region->zone)}}</option>
                    @endforeach
                @endif
            </select>
            <div class="invalid-feedback">
                Please choose a Zone.
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="district" title="5"><strong>District</strong></label>
            <select class="custom-select" title="" id="district" name="district" wire:change="district($event.target.value)">
                <option value="" selected>None</option>
                @if (!empty($zoneValue))
                    @foreach ($zoneValue as $zone)
                        <option value="{{strtoupper($zone->district)}}">{{strtoupper($zone->district)}}</option>
                    @endforeach
                @endif
            </select>
            <div class="invalid-feedback">
                Please choose a Region.
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="branch" title="2"><strong>Branch</strong></label>
            <select class="custom-select" title="" id="branch" name="branch" >
                <option value="" selected>None</option>
                @if (!empty($districtValue))
                    @foreach ($districtValue as $zone)
                        <option value="{{strtoupper($zone->name)}}">{{strtoupper($zone->name)}}</option>
                    @endforeach
                @endif
            </select>
            <div class="invalid-feedback">
                Please choose a District.
            </div>
        </div>
    </div>
</div>
