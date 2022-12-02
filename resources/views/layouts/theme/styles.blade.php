    <link href="{{asset('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('assets/js/loader.js')}}"></script>

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/structure.css')}}" rel="stylesheet" type="text/css" class="structure" />

    <link href="{{asset('plugins/font-icons/fontawesome/css/fontawesome.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/elements/avatar.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/apps/scrumboard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/apps/notes.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/widgets/modules-widgets.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">

    <!--Creamos un style personalizado-->
    <style>
    aside{
        display: none !important;
    }

    .page-item.active .page-link{
        z-index: 3;
        color: #fff;
        background-Color:#000000;
        border-Color: #e7515a;
    }

    @media(max-width: 480px)
    {
        .mtmobile{margin-bottom: 20px !important;}
        .mtmobile{margin-bottom: 10px !important;}

        .hideonsm{display: none !important;}
        .inblock{display:Block;}
    }
    /*BackGround Sidebar*/
    .sidebar-theme #compactSidebar {
    background: #000000 !important;
    }
    /*BackGround Sidebar*/
    .header {
    background: #e7515a !important;
    }
    /*BackGround Sidebar Collapse*/
    .header-container .sidebarCollapse {
    color: #3B3F5C !important;
}

 /*search box background*/
 .navbar .navbar-item .nav-item form.form-inline input.search-form-control {
    font-size: 15px;
    background-color: #000000 !important;
    padding-right: 40px;
    padding-top: 12px;
    border: none;
    color: #fff;
    box-shadow: none;
    border-radius: 30px;
}

    </style>
<link rel="stylesheet" type="text/css" href="{{asset('plugins/flatpickr/flatpickr.dark.css')}}">
@livewireStyles
