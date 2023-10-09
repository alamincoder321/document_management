<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('backend')}}/css/bootstrap.min.css">
<!-- Fonts -->
<link rel="stylesheet" type="text/css" href="{{asset('backend')}}/fonts/line-icons.css">
<!-- Main Style -->
<link rel="stylesheet" type="text/css" href="{{asset('backend')}}/css/datatable.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('backend')}}/css/main.css">
<!-- Responsive Style -->
<link rel="stylesheet" type="text/css" href="{{asset('backend')}}/css/responsive.css">
<!-- sweet alert css -->
<link rel="stylesheet" href="{{asset('backend')}}/css/sweetalert.css">
<link href="{{asset('backend')}}/css/toastr.min.css" rel="stylesheet" />
@stack('css')
<style>
    table.dataTable {
        margin: 0 !important;
        width: 100% !important;
        border-collapse: collapse !important;
    }

    table.dataTable>thead {
        background: #e22a6f80 !important;
    }

    table.dataTable>thead>tr>th {
        padding: 2px 3px !important;
        color:white;
    }

    table.dataTable>thead>tr>th:first-child {
        width: 6% !important;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_desc:before {
        bottom: 4px !important;
    }

    table.dataTable thead .sorting::after,
    table.dataTable thead .sorting_desc::after {
        bottom: 4px !important;
    }

    table.dataTable>tbody>tr>td {
        padding: 2px 3px !important;
    }

    .ImageBackground .imageShow {
        display: block;
        height: 120px;
        width: 135px;
        margin-top: 10px;
        border: 1px solid #27ff00;
        border-bottom: 0;
        box-sizing: border-box;
    }

    .ImageBackground input {
        display: none;
    }

    .ImageBackground label {
        background: green;
        width: 135px;
        color: white;
        padding: 5px;
        text-align: center;
        cursor: pointer;
        font-family: monospace;
        text-transform: uppercase;
        margin: 0 !important;
    }
</style>