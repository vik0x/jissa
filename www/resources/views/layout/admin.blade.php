<?php
$privs = \DB::table('sys_privilegios as pr')
  ->select('p.accion','m.slug','m.nombre')
  ->join('sys_modulo as m','m.id_modulo','=','pr.id_modulo')
  ->join('sys_permiso as p','p.id_permiso','=','pr.id_permiso')
  ->where('pr.id_rol',session('rol'))
  ->where('pr.estatus',1)
  ->where('m.estatus',1)
  ->where('p.estatus',1)
  ->where('pr.eliminado',0)
  ->where('m.eliminado',0)
  ->where('p.eliminado',0)
  ->where('p.nombre','Listar')
  ->get();

foreach($privs as $key => $priv){
  if(!in_array(mb_strtolower($priv->nombre), ['privilegios'])){
    $privilegios[$key]['slug'] = trim($priv->accion) == "" ? '/administrador/' . $priv->slug : '/' . $priv->accion . '/' . $priv->slug;
    $privilegios[$key]['nombre'] = $priv->nombre;
  }
}
// dd($privilegios);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>@yield('titulo','Salí')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{asset('/pages/ico/60.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/pages/ico/76.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/pages/ico/120.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/pages/ico/152.png')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('/assets/css/images/favicon.ico')}}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('/assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/plugins/boostrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('/assets/plugins/bootstrap-select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('/assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('/pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{asset('/pages/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/css/sumoselect.min.css')}}" rel="stylesheet">
    <!--Carga de imagenes-->
    <link href="{{asset('/assets/css/uploadfile.css')}}" rel="stylesheet">
    <!--[if lte IE 9]>
  <link href="assets/plugins/codrops-dialogFx/dialog.ie.css" rel="stylesheet" type="text/css" media="screen" />
  <![endif]-->
  <!--Textarea de Texto enriquecido-->
  <link href="{{asset('/assets/plugins/summernote/css/summernote.css')}}" rel="stylesheet" type="text/css" media="screen">
  @yield('css')
  </head>
  <body class="fixed-header">
    <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
      
      <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        <img src="{{asset('/assets/img/logo_white.png')}}" alt="logo" class="brand" data-src="{{asset('/assets/img/logo_white.png')}}" data-src-retina="{{asset('/assets/images/logo.png')}}" width="78" height="22">
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
          <li class="m-t-30 ">
            <a href="{{url('/administrador')}}" class="detailed">
              <span class="title">Inicio</span>
              <!-- <span class="details">12 New Updates</span> -->
            </a>
            <span class="bg-success icon-thumbnail"><i class="pg-home"></i></span>
          </li>
          @if(isset($privilegios))
            @foreach($privilegios as $privilegio)
            <li class="">
              <a href="{{url($privilegio['slug'] . '.html')}}" class="detailed">
                <span class="title">{{$privilegio['nombre']}}</span>
                <!-- <span class="details">12 New Updates</span> -->
              </a>
              <span class="icon-thumbnail"><?php echo ucwords(substr($privilegio['nombre'],0,2)); ?></span>
            </li>
            @endforeach
          @endif
          
          <li>
            <a href="javascript:;"><span class="title">Papelera</span>
              <?php
              $modulos = \DB::table('sys_modulo as m')
                ->select(
                  \DB::raw('distinct m.nombre'),
                  'm.id_modulo as id',
                  'm.slug'
                )
                ->join('sys_papelera as p','p.id_tipo','=','m.id_modulo')
                ->join('sys_privilegios as pr','pr.id_modulo','=','m.id_modulo')
                ->where('p.status',1)
                ->where('pr.id_rol','=',session('rol'))
                ->where('pr.id_permiso','=',5)
                ->orderBy('nombre')
                ->get();
              // print_r($modulos);exit;
              ?>
            <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-trash" aria-hidden="true"></i></span>
            <ul class="sub-menu">
              @foreach($modulos as $modulo)
              <li class="">
                <a href="{{url('administrador/restaurar/' . $modulo->slug . $modulo->id . '.html')}}">{{$modulo->nombre}}</a>
                <span class="icon-thumbnail">P{{mb_strtolower(substr($modulo->nombre,0,1))}}</span>
              </li>
              @endforeach
            </ul>
          </li>
          
          
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container ">
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <div class="container-fluid relative">
          <!-- LEFT SIDE -->
          <div class="pull-left full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="header-inner">
              <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                <span class="icon-set menu-hambuger"></span>
              </a>
            </div>
            <!-- END ACTION BAR -->
          </div>
          <div class="pull-center hidden-md hidden-lg">
            <div class="header-inner">
              <div class="brand inline">
                <img src="{{asset('/assets/img/logo.png')}}" alt="logo" data-src="{{asset('/assets/img/logo.png')}}" data-src-retina="{{asset('/assets/img/logo_2x.png')}}" width="78" height="22">
              </div>
            </div>
          </div>
          <!-- RIGHT SIDE -->
          <div class="pull-right full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="header-inner">
              <a href="#" class="btn-link visible-sm-inline-block visible-xs-inline-block" data-toggle="quickview" data-toggle-element="#quickview">
                <span class="icon-set menu-hambuger-plus"></span>
              </a>
            </div>
            <!-- END ACTION BAR -->
          </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        
        <div class=" pull-right">
          <div class="header-inner">
            <a href="#" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs" data-toggle="quickview" data-toggle-element="#quickview"></a>
          </div>
        </div>
        <div class=" pull-right">
          <!-- START User Info-->
          <div class="visible-lg visible-md m-t-10">
            <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
              <span class="semi-bold">{{\Auth::user()->nombre}}</span> <span class="text-master">{{\Auth::user()->apellido}}</span>
            </div>
            <div class="dropdown pull-right">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline m-t-5">
                <img src="{{asset(\Auth::user()->imagen_perfil)}}" alt="" data-src="{{asset(\Auth::user()->imagen_perfil)}}" data-src-retina="{{asset('/assets/img/profiles/avatar_small2x.jpg')}}" width="32" height="32">
            </span>
              </button>
              <ul class="dropdown-menu profile-dropdown" role="menu">
                
                <li class="bg-master-lighter">
                  <a href="{{url('cerrar.html')}}" class="clearfix">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                  </a>
                </li>

              </ul>

            </div>
          </div>
          <!-- END User Info-->
        </div>
      </div>
      <!-- END HEADER -->
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
          <!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
              <div class="inner">
                
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg" id="ab-contenido">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            @yield('contenido')
            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
              <span class="hint-text">Copyright &copy; 2017 </span>
              <span class="font-montserrat">Sal'i</span>.
              <span class="hint-text">Todos los derechos reservados. | Developed by <a href="http://vgutierrez.mx">Víctor Gutiérrez</a></span>
              <!--span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a></span-->
            </p>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
   
    <!-- BEGIN VENDOR JS -->
    <script src="{{asset('/assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery/jquery-1.11.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/boostrapv3/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-bez/jquery.bez.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/plugins/bootstrap-select2/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/plugins/classie/classie.js')}}"></script>
    <script src="{{asset('/assets/plugins/switchery/js/switchery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/js/jquery.sumoselect.min.js')}}" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{asset('/pages/js/pages.min.js')}}"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{asset('/assets/js/scripts.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
    <script type="text/javascript" src="{{asset('/assets/js/notify.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/js/layout/admin.js')}}"></script>
    <!--Para la carga de archivos-->
    <script src="{{asset('/assets/js/jquery.uploadfile.min.js')}}"></script>

     <!--Textarea de texto enriquecido-->
    <script src="{{asset('/assets/plugins/summernote/js/summernote.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.summernote').summernote({
            height: 200,
            onfocus: function(e) {
                $('body').addClass('overlay-disabled');
            },
            onblur: function(e) {
                $('body').removeClass('overlay-disabled');
            }
        });
    </script>
    
    @yield('script')
    @if(session()->has('error'))
      <script>
        $(function(){
          //https://notifyjs.com/
          $.notify(
            "{{session('error')}}", 
            {
              globalPosition:"top center",
              className:"error",
            }
          );
        });
      </script>
    @endif

    @if(session()->has('success'))
        <script>
          $(function(){
            //https://notifyjs.com/
            $.notify(
              "{{session('success')}}", 
              {
                globalPosition:"top center",
                className:"success",
              }
            );
          });
        </script>
    @endif

    @if(session()->has('danger'))
        <script>
          $(function(){
            //https://notifyjs.com/
            $.notify(
              "{{session('danger')}}", 
              {
                globalPosition:"top center",
                className:"danger",
              }
            );
          });
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function () {
            window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll:false, captionFormatAllSelected: "Yeah, OK, so everything." });


            $('.SlectBox').on('sumo:opened', function(o) {
                console.log("dropdown opened", o)
            });

        });
    </script>
  </body>
</html>