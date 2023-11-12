<div class="row">
    {{-- The whole world belongs to you. --}}

    <div class="col-md-3 mb-2">
        <label for="product_id"><strong>Nature of facility availed</strong></label>
        <select class="custom-select" required id="product_id"
                name="product_id" wire:change="nature_of_facility($event.target.value)">
            <option value="">None</option>
            @foreach($nature_of_facility as $nf)
                <option value="{{$nf->id}}"  @if(!empty($customer) && $customer->product_id == $nf->id) selected @endif >
                    {{$nf->product_name}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 mb-2">
        <label for="product_type_id"><strong>Type of facility approved</strong></label>
        <select class="custom-select" required id="product_type_id" name="product_type_id">
            <option value="" selected>None</option>
            @if(!empty($customer) && $check_flag == false)
                <option value="{{$customer->product_type_id}}" selected>{{\App\Models\ProductType::find($customer->product_type_id)->product_type}}</option>
            @endif

            @if($type_of_facility_flag)
                @foreach($type_of_facility as $tf)
                    <option value="{{$tf->id}}" @if(!empty($customer) && $customer->product_type_id == $tf->id) selected @endif  >
                        {{$tf->product_type}}
                    </option>
                @endforeach
            @endif
        </select>
    </div>


    <div class="col-md-3 mb-3">
        <label for="renewal_enhancement_fresh_sanction"><abbr
                title="renewal_enhancement_fresh_sanction"><strong>Renewal/Enhancement </strong></abbr></label>

        <select class="form-control select2bs4" required id="renewal_enhancement_fresh_sanction" style="width: 100%;" name="renewal_enhancement_fresh_sanction">
            <option value="">None</option>

            <option value="Renewal" @if(!empty($customer) && $customer->renewal_enhancement_fresh_sanction == "Renewal") selected @endif >Renewal</option>
            <option value="Enhancement" @if(!empty($customer) && $customer->renewal_enhancement_fresh_sanction == "Enhancement") selected @endif >Enhancement</option>
            <option value="Fresh Sanction" @if(!empty($customer) && $customer->renewal_enhancement_fresh_sanction == "Fresh Sanction") selected @endif >Fresh Sanction</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label for="amount_sanctioned"><strong>Amount Sanctioned</strong>&nbsp;<span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="amount_sanctioned" required
               name="amount_sanctioned" @if(request()->routeIs('customer.show'))  @endif step="0.01" min="0" @if(!empty($customer)) value="{{$customer->amount_sanctioned}}" @endif>
    </div>
</div>
