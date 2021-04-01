@extends("vendor.admin.layout")

@section("content")
    <a href="#"><strong><span class="fa fa-dashboard"></span>Bulk Import</strong></a>
    <br>
    <hr>
    @if(session("error"))
        <div class="alert alert-danger">
            <span>{{ session("error") }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    @if(session("successImport"))
        <div class="alert alert-success">
            <span>{{ session("successImport") }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="mt-3">
        <form action="{{ route("admin.create-users-from-excel") }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="choose-excel-file">
                <input type="file" name="excelFile">
                <span class="select-text">Select Excel</span>
            </div>
            <button type="submit" class="btn btn-primary excel-file-send">Send</button>
        </form>
    </div>
@endsection

@section("style")
    <style type="text/css">
        .choose-excel-file {
            
            height: 30px;
        }
        .select-text {
            position: absolute;
            padding: 5px 11px;
            background-color: #428bca;
            color: #FFF;
            z-index: 0;
        }
        input[name=excelFile] {
            opacity: 0;
            position: absolute;
            width: 99px;
            height: 30px;
            z-index: 1;
        }
        .excel-file-send {
            margin-top: 10px;
        }
    </style>
@endsection