@extends('user.layout.app')
@section('title', 'Clients')
@section('style')
<style>

</style>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-right align-items-center">
                            <h4>Sale History</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Unit id</th>
                                            <th>From Client</th>
                                            <th>To Client</th>
                                            <th>Sales Person</th>
                                            <th>Transfer Fee</th>
                                            <th>Status</th>
                                            <th>Comment</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($clientHistory)) { ?>
                                            <?php foreach ($clientHistory as $value) { ?>
                                                <tr>
                                                    <td><?php echo $value['id'] ?></td>
                                                    <td><?php echo $value['inventory_id'] ?></td>
                                                    <td><?php echo $value['from']['name']; ?></td>
                                                    <td><?php echo $value['to']['name'] ?></td>
                                                    <td><?php echo $value['sale_person']['name'] ?></td>
                                                    <td><?php echo $value['price'] ?></td>
                                                    <td><?php echo $value['status'] ?></td>
                                                    <td><?php echo $value['comment'] ?></td>
                                                    <td><?php echo $value['created_at'] ?></td>
                                                    <td>
                                                        <a href="{{route('sale.show', ['RolePrefix' => RolePrefix(),$value['from']['id']])}}" class="btn btn-primary btn-sm px-1 py-0" title="Edit"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
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

@endsection