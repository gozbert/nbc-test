<form id="addForm" method="post" action="javascript:void(0)">
    @csrf
    <div class="modal-body p-0 m-0 rounded">
        <div class="ibox">
            <div class="ibox-title text-uppercase">
                <i class="fa fa-plus-circle"></i> Fetch Data
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="alert alert-danger d-none col-12" id="errors" role="alert"> </div>
                </div>
                <div class="row p-3">
                    Are you sure you want to fetch the data from API
                </div>

            </div>
            <div class="ibox-footer">
                <div class="float-right pb-1">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close"></i>
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" data-id="0" data-url="{{ route('ripoti.store') }}"
                        data-action="add"
                        onclick="savingData(this, '#processModal', '#ripotiTable', '#errors')">
                        <i class="fa fa-save"></i> Fetch
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
