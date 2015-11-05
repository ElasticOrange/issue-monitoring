var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var bowerDir = './resources/assets/bower/';

elixir(function(mix) {
    mix.sass('app.scss')
    .styles([
    	  'bootstrap/dist/css/bootstrap.min.css'
    	, 'metisMenu/dist/metisMenu.min.css'
    	, 'startbootstrap-sb-admin-2/dist/css/timeline.css'
    	, 'startbootstrap-sb-admin-2/dist/css/sb-admin-2.css'
    	, 'morrisjs/morris.css'
    	, 'font-awesome/css/font-awesome.min.css'
        , 'jqwidgets/jqwidgets/styles/jqx.base.css'
        , 'datatables/media/css/dataTables.bootstrap.css'
        , 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'
    	] , 'public/css/style.css', bowerDir)
    .scripts([
          'jquery/dist/jquery.min.js'
        , 'lodash/lodash.min.js'
        , 'bootstrap/dist/js/bootstrap.min.js'
        , 'metisMenu/dist/metisMenu.js'
        , 'startbootstrap-sb-admin-2/dist/js/sb-admin-2.js'
        , 'datatables/media/js/jquery.dataTables.min.js'
        , 'datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'
        , 'jqwidgets/jqwidgets/jqxcore.js'
        , 'jqwidgets/jqwidgets/jqxdata.js'
        , 'jqwidgets/jqwidgets/jqxbuttons.js'
        , 'jqwidgets/jqwidgets/jqxscrollbar.js'
        , 'jqwidgets/jqwidgets/jqxpanel.js'
        , 'jqwidgets/jqwidgets/jqxtree.js'
        , 'jqwidgets/jqwidgets/jqxdragdrop.js'
        , 'jqwidgets/jqwidgets/jqxcheckbox.js'
        , 'moment/min/moment.min.js'
        , 'moment/locale/ro.js'
        , 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
        ], 'public/js/all.js', bowerDir)
/*    .scripts([
			  '../customJs/deleteDocument.js'
			, '../customJs/ajaxForms.js'
			, '../customJs/jqxtreeActivation.js'
			, '../customJs/datatableTranslated.js'
			, '../customJs/SetPublishedAjax.js'
			]
			, 'public/js/custom.js'
			, bowerDir)*/
	.styles(
			[
				  'style.css'
				, 'app.css'
			]
			, 'public/css/all.css'
			, 'public/css/'
		)
	.copy(
		   'resources/assets/bower/font-awesome/fonts/',
		   'public/build/fonts/'
		   )
	.copy(
		   'resources/assets/bower/bootstrap/dist/fonts/',
		   'public/build/fonts/'
		   )
	.copy(
			'resources/assets/bower/jqwidgets/jqwidgets/styles/images/',
			'public/build/css/images/'
		)
	.copy(
			'resources/assets/bower/datatables/media/images/',
			'public/build/images/'
		)
	.version([
			  'css/all.css'
			, 'js/all.js'
//            , 'js/custom.js'
		]);
});
