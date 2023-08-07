<div class="form-row">
    <div class="col-md-3 mb-3">
        <label for="principle_amount"><strong>Principle Amount</strong></label>
        <input type="number" class="form-control" value="{{$principle_amount}}" wire:model="principle_amount"  required name="principle_amount" min="0.00" id="principle_amount" step="0.01">
    </div>
    <div class="col-md-3 mb-3">
        <label for="markup_amount"><strong>Markup Amount</strong></label>
        <input type="number" step="0.01" min="0.00" id="markup_amount" value="{{$principle_amount}}" wire:model="markup_amount"  required class="form-control" name="markup_amount">
    </div>
    <div class="col-md-3 mb-3">
        <label for="installment_insurance"><strong>Insurance (if any)</strong></label>
        <input type="number" id="installment_insurance" min="0.00" value="{{$principle_amount}}" wire:model="installment_insurance"  step="0.01" class="form-control" name="installment_insurance">
    </div>
    <div class="col-md-3 mb-3">
        <label for="total_installment"><strong>Total Installment</strong></label>
        <input type="number" id="total_installment" required class="form-control" value="{{$total_installment}}"  name="total_installment" readonly>
    </div>
</div>
