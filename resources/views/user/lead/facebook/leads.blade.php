@extends('user.layout.app')
@section('title', 'Property')
@section('style')


@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>:Leads Table</h4>
                            <a href="{{route('webhook.lead_assign_to_mangers', ['RolePrefix' => RolePrefix(),$form_id,$token])}}" class="btn btn-primary" style="margin-left: auto; display: block;">Assign To Managers</a>
                            <a href="{{route('webhook.lead_assign_to_sale_person', ['RolePrefix' => RolePrefix(),$form_id,$token])}}" class="btn btn-primary" style="margin-left: auto; display: block;">Assign To Sale Person</a>
                        </div>
                        <div class="card-body">
                            <ul id="list"></ul>
                            @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                            <div class="table-responsive">
                                <table class="table text-center table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Facebook Leads Data</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table text-center table-striped" id="myTable11">
                                    <thead class="display">
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
											<th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($data->data)) { ?>
                                            <?php foreach ($data->data as $key => $val) { ?>
                                                <?php $fields = array_reduce($val->field_data, static function ($fields, $entry) {
                                                   if ($entry->name == 'EMAIL' || $entry->name == 'email') {
                                                    $fields['email'] = $entry->values;
                                                }
                                                if ($entry->name == 'PHONE' || $entry->name == "phone_number") {
                                                    $fields['phone_number'] = $entry->values;
                                                }
                                                if ($entry->name == 'FULL_NAME' || $entry->name == "full_name") {
                                                    $fields['full_name'] = $entry->values;
                                                }
                                                    return $fields;
                                                }); ?>
                                                <?php if (!empty($fields['full_name'][0]) || !empty($fields['phone_number'][0]) || !empty($fields['email'][0])) { ?>
                                                    <tr>
                                                        <td>
                                                            <?php if (!empty($fields['full_name'][0])) { ?>
                                                                <?php echo $fields['full_name'][0]; ?>  
                                                            <?php } else { ?>

                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($fields['phone_number'][0])) { ?>
                                                                <?php echo $fields['phone_number'][0]; ?>
                                                            <?php } else { ?>

                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($fields['email'][0])) { ?>
                                                                <?php echo $fields['email'][0]; ?>
                                                            <?php } else { ?>

                                                            <?php } ?>
                                                        </td>
														 <td>
                                                            <?php
                                                            $timestamp = strtotime($val->created_time);
                                                            echo date('Y-m-d H:i:s', $timestamp);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#myTable11').DataTable({
            "bInfo": false,
			"ordering": false
        });
        $(".display").hide();
    });
</script>
@endsection
