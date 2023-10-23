<div class="form-row">
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="col-md-3 mb-2">
        <label for="primary"><strong>Primary</strong></label>
        <select class="form-control select2bs4" id="primary" name="primary" required wire:model="selection">
            <option value="">None</option>
            <option value="Hypothecation">Hypothecation</option>
            <option value="Lien">Lien</option>
            <option value="Pledge">Pledge</option>
            <option value="Mortgage">Mortgage</option>
            <option value="Personal Guarantee">Personal Guarantee</option>
            <option value="Lease">Lease</option>
        </select>
    </div>

    @if($selection == "Hypothecation")
        <div class="col-md-3 mb-3">
            <label for="secondary"><strong>Secondary</strong></label>
            <input type="text" class="form-control" id="secondary" name="secondary">
        </div>
        <div class="col-md-3 mb-3">
            <label for="ownership"><strong>Ownership</strong></label>
            <input type="text" class="form-control" id="ownership" name="ownership">
        </div>
        <div class="col-md-3 mb-2">
            <label for="market_value"><strong>Market Value</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="market_value" name="market_value">
        </div>
        <div class="col-md-3 mb-2">
            <label for="fsv"><strong>FSV</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="fsv" name="fsv">
        </div>
        <div class="col-md-3 mb-3">
            <label for="remarks"><strong>Remarks / Additional Details</strong></label>
            <textarea class="form-control" id="remarks" name="remarks"></textarea>
        </div>
    @elseif($selection == "Lien")
        <div class="col-md-3 mb-3">
            <label for="ac_no"><strong>A/C No</strong></label>
            <input type="text" class="form-control" id="ac_no" name="ac_no">
        </div>
        <div class="col-md-3 mb-3">
            <label for="title"><strong>Title</strong></label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="col-md-3 mb-3">
            <label for="branch_id"><strong>Please select branch</strong></label>
            <select class="form-control select2bs4" id="branch_id" style="width: 100%;" name="branch_id" required>
                <option value="">Please select branch</option>
                @foreach(\App\Models\Branch::all() as $branch)
                    <option value="{{$branch->id}}">{{$branch->code}}-{{$branch->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label for="amount"><strong>Amount</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="amount" name="amount">
        </div>

        <div class="col-md-3 mb-3">
            <label for="secondary"><strong>Secondary</strong></label>
            <input type="text" class="form-control" id="secondary" name="secondary">
        </div>
        <div class="col-md-3 mb-3">
            <label for="ownership"><strong>Ownership</strong></label>
            <input type="text" class="form-control" id="ownership" name="ownership">
        </div>
        <div class="col-md-3 mb-2">
            <label for="market_value"><strong>Market Value</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="market_value" name="market_value">
        </div>
        <div class="col-md-3 mb-2">
            <label for="fsv"><strong>FSV</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="fsv" name="fsv">
        </div>
        <div class="col-md-3 mb-3">
            <label for="remarks"><strong>Remarks / Additional Details</strong></label>
            <textarea class="form-control" id="remarks" name="remarks"></textarea>
        </div>
    @elseif($selection == "Pledge")
        <div class="col-md-3 mb-3">
            <label for="tdr_sss_dsc_certificate"><strong>TDR/SSS/DSC/Certificate No</strong></label>
            <input type="text" class="form-control" id="tdr_sss_dsc_certificate" name="tdr_sss_dsc_certificate">
        </div>
        <div class="col-md-3 mb-3">
            <label for="date_of_issuance"><strong>Date Of Issuance</strong></label>
            <input type="date" class="form-control" id="date_of_issuance" name="date_of_issuance">
        </div>
        <div class="col-md-3 mb-3">
            <label for="issuing_office"><strong>Issuing Office</strong></label>
            <input type="text"  class="form-control" id="issuing_office" name="issuing_office">
        </div>
        <div class="col-md-3 mb-3">
            <label for="pledge_amount"><strong>Amount</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="pledge_amount" name="pledge_amount">
        </div>

        <div class="col-md-3 mb-3">
            <label for="secondary"><strong>Secondary</strong></label>
            <input type="text" class="form-control" id="secondary" name="secondary">
        </div>
        <div class="col-md-3 mb-3">
            <label for="ownership"><strong>Ownership</strong></label>
            <input type="text" class="form-control" id="ownership" name="ownership">
        </div>
        <div class="col-md-3 mb-2">
            <label for="market_value"><strong>Market Value</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="market_value" name="market_value">
        </div>
        <div class="col-md-3 mb-2">
            <label for="fsv"><strong>FSV</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="fsv" name="fsv">
        </div>
        <div class="col-md-3 mb-3">
            <label for="remarks"><strong>Remarks / Additional Details</strong></label>
            <textarea class="form-control" id="remarks" name="remarks"></textarea>
        </div>


    @elseif($selection == "Mortgage")
        <div class="col-md-3 mb-3">
            <label for="secondary"><strong>Secondary</strong></label>
            <input type="text" class="form-control" id="secondary" name="secondary">
        </div>
        <div class="col-md-3 mb-3">
            <label for="ownership"><strong>Ownership</strong></label>
            <input type="text" class="form-control" id="ownership" name="ownership">
        </div>
        <div class="col-md-3 mb-2">
            <label for="market_value"><strong>Market Value</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="market_value" name="market_value">
        </div>
        <div class="col-md-3 mb-2">
            <label for="fsv"><strong>FSV</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="fsv" name="fsv">
        </div>
        <div class="col-md-3 mb-3">
            <label for="remarks"><strong>Remarks / Additional Details</strong></label>
            <textarea class="form-control" id="remarks" name="remarks"></textarea>
        </div>
    @elseif($selection == "Personal Guarantee")
        <div class="col-md-3 mb-3">
            <label for="secondary"><strong>Secondary</strong></label>
            <input type="text" class="form-control" id="secondary" name="secondary">
        </div>
        <div class="col-md-3 mb-3">
            <label for="ownership"><strong>Ownership</strong></label>
            <input type="text" class="form-control" id="ownership" name="ownership">
        </div>
        <div class="col-md-3 mb-2">
            <label for="market_value"><strong>Market Value</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="market_value" name="market_value">
        </div>
        <div class="col-md-3 mb-2">
            <label for="fsv"><strong>FSV</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="fsv" name="fsv">
        </div>
        <div class="col-md-3 mb-3">
            <label for="remarks"><strong>Remarks / Additional Details</strong></label>
            <textarea class="form-control" id="remarks" name="remarks"></textarea>
        </div>
    @elseif($selection == "Lease")

        <div class="col-md-3 mb-3">
            <label for="secondary"><strong>Secondary</strong></label>
            <input type="text" class="form-control" id="secondary" name="secondary">
        </div>
        <div class="col-md-3 mb-3">
            <label for="ownership"><strong>Ownership</strong></label>
            <input type="text" class="form-control" id="ownership" name="ownership">
        </div>
        <div class="col-md-3 mb-2">
            <label for="market_value"><strong>Market Value</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="market_value" name="market_value">
        </div>
        <div class="col-md-3 mb-2">
            <label for="fsv"><strong>FSV</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="fsv" name="fsv">
        </div>
        <div class="col-md-3 mb-3">
            <label for="remarks"><strong>Remarks / Additional Details</strong></label>
            <textarea class="form-control" id="remarks" name="remarks"></textarea>
        </div>

        <div class="col-md-4 mb-3">
        </div>
        <div class="col-md-4 mb-3">
        </div>
        <div class="col-md-4 mb-3">
            <label for="orignal_reg_book_obtained"><strong>Original Registration Book of Vehicle Obtained</strong></label>
            <select class="form-control" id="orignal_reg_book_obtained" name="orignal_reg_book_obtained">
                <option value="">None</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="duplicate_key_vehicle_obtained"><strong>Original Registration Book of Vehicle Obtained</strong></label>
            <select class="form-control" id="duplicate_key_vehicle_obtained" name="duplicate_key_vehicle_obtained">
                <option value="">None</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="date_obtained"><strong>Date Obtained</strong></label>
            <input type="number" step="0.01" min="0.00" class="form-control" id="date_obtained" name="date_obtained">
        </div>
    @endif



</div>
