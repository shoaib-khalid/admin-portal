
<div class="card">
    <div class="card-header">
        <h4>Daily Summary</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table-1">
                <thead>
                    <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th>Task Name</th>
                    <th>Progress</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                {{ $post->id }}
                            </td>
                            <td>
                                {{ $post->title }}
                            </td>
                            <td class="align-middle">
                                <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                                    <div class="progress-bar bg-success" data-width="100%"></div>
                                </div>
                            </td>
                            <td>2018-01-20</td>
                            <td><div class="badge badge-success">Completed</div></td>
                            <td><a href="#" class="btn btn-secondary">Detail</a></td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
