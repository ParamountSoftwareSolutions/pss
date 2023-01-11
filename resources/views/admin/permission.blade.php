@extends('admin.layout.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Permissions</div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <span>{{ $message }}</span>
                    </div>
                    @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <span>{{ $message }}</span>
                    </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{route('permission_store')}}">
                            @csrf
                            <h5>Project Management</h5>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="control-label">Society</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Society]" value="off">
                                        <input type="checkbox" name="key[Society]" class="custom-switch-input" value="on" <?php if (!empty($check->Society == "on")) {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Society Quantity</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="number" name="key[SocietyQuantity]" class="form-control" value="<?php echo $check->SocietyQuantity; ?>">
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Farmhouse </div>
                                    <label class="custom-switch mt-2" style="margin-left: -2rem">
                                        <input type="hidden" name="key[Farmhouse]" value="off">
                                        <input type="checkbox" name="key[Farmhouse]" class="custom-switch-input" <?php if (!empty($check->Farmhouse == "on")) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Farmhouse Quantity</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="number" name="key[FarmhouseQuantity]" class="form-control" value="<?php echo $check->FarmhouseQuantity; ?>">
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Building</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Building]" value="off">
                                        <input type="checkbox" name="key[Building]" class="custom-switch-input" <?php if (!empty($check->Building == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Building Quantity</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="number" name="key[BuildingQuantity]" class="form-control" value="<?php echo $check->BuildingQuantity; ?>">
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Property</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Property]" value="off">
                                        <input type="checkbox" name="key[Property]" class="custom-switch-input" <?php if (!empty($check->Property == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Property Quantity</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="number" name="key[PropertyQuantity]" class="form-control" value="<?php echo $check->PropertyQuantity; ?>">
                                    </label>
                                </div>
                            </div>
                            <h5>Lead Management</h5>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="control-label">lead module</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[lead_module]" value="off">
                                        <input type="checkbox" name="key[lead_module]" class="custom-switch-input" <?php if (!empty($check->lead_module == "on")) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Facebook lead module</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[facebook_lead_module]" value="off">
                                        <input type="checkbox" name="key[facebook_lead_module]" class="custom-switch-input" <?php if (!empty($check->facebook_lead_module == "on")) {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                    </label>
                                </div>
                            </div>
                            <h5>Marketing </h5>
                            <h6>SMS... </h6>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="control-label">warid </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[warid]" value="off">
                                        <input type="checkbox" name="key[warid]" class="custom-switch-input" <?php if (!empty($check->warid == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">jazz </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[jazz]" value="off">
                                        <input type="checkbox" name="key[jazz]" class="custom-switch-input" <?php if (!empty($check->jazz == "on")) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Ufone </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Ufone]" value="off">
                                        <input type="checkbox" name="key[Ufone]" class="custom-switch-input" <?php if (!empty($check->Ufone == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">zong </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[zong]" value="off">
                                        <input type="checkbox" name="key[zong]" class="custom-switch-input" <?php if (!empty($check->zong == "on")) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                    </label>
                                </div>
                            </div>
                            <h6>Email / WhatsApp... </h6>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="control-label">Email </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Email]" value="off">
                                        <input type="checkbox" name="key[Email]" class="custom-switch-input" <?php if (!empty($check->Email == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">WhatsApp </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[WhatsApp]" value="off">
                                        <input type="checkbox" name="key[WhatsApp]" class="custom-switch-input" <?php if (!empty($check->WhatsApp == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                            </div>
                            <h5>Payment Method </h5>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="control-label">Paypal </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Paypal]" value="off">
                                        <input type="checkbox" name="key[Paypal]" class="custom-switch-input" <?php if (!empty($check->Paypal == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Bank transfer</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Bank_transfer]" value="off">
                                        <input type="checkbox" name="key[Bank_transfer]" class="custom-switch-input" <?php if (!empty($check->Bank_transfer == "on")) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Easypaisa </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Easypaisa]" value="off">
                                        <input type="checkbox" name="key[Easypaisa]" class="custom-switch-input" <?php if (!empty($check->Easypaisa == "on")) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Jazzcash </div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[Jazzcash]" value="off">
                                        <input type="checkbox" name="key[Jazzcash]" class="custom-switch-input" <?php if (!empty($check->Jazzcash == "on")) {
                                                                                                                    echo 'checked';
                                                                                                                } ?>>
                                    </label>
                                </div>
                            </div>
                            <h5>Management</h5>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="control-label">Bill Management</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[bill_management]" value="off">
                                        <input type="checkbox" name="key[bill_management]" class="custom-switch-input" <?php if (!empty($check->bill_management == "on")) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="control-label">Application Management</div>
                                    <label class="custom-switch mt-2 " style="margin-left: -2rem">
                                        <input type="hidden" name="key[application_management]" value="off">
                                        <input type="checkbox" name="key[application_management]" class="custom-switch-input" <?php if (!empty($check->application_management == "on")) {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                    </label>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection