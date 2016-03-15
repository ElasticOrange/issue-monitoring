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
	mix.sass(['app.scss', 'customFront.scss'])
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
		, 'jquery-ui/themes/smoothness/jquery-ui.css'
		] , 'public/css/style.css', bowerDir)
	.styles([
		  'bootstrap/dist/css/bootstrap.min.css'
		, 'font-awesome/css/font-awesome.min.css'
		, 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'
		, 'jquery-ui/themes/smoothness/jquery-ui.css'
		] , 'public/css/front-style.css', bowerDir)
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
		, 'moment/min/moment.min.js'
		, 'moment/locale/ro.js'
		, 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
		, 'typeahead.js/dist/typeahead.bundle.min.js'
		, 'ckeditor/ckeditor.js'
		, 'jquery-ui/jquery-ui.js'
		], 'public/js/all.js', bowerDir)
	.scripts([
		  'jquery/dist/jquery.min.js'
		, 'lodash/lodash.min.js'
		, 'bootstrap/dist/js/bootstrap.min.js'
		, 'moment/min/moment.min.js'
		, 'moment/locale/ro.js'
		, 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
		, 'jquery-ui/jquery-ui.js'
		], 'public/js/main.js', bowerDir)
	.scripts([
			  '../customCss/customFront.css'
			]
			, 'public/css/customFront.css'
			, bowerDir)
/*    .scripts([
			  '../customJs/deleteDocument.js'
			, '../customJs/ajaxForms.js'
			, '../customJs/jqxtreeActivation.js'
			, '../customJs/datatableTranslated.js'
			, '../customJs/SetPublishedAjax.js'
			]
			, 'public/js/custom.js'
			, bowerDir)*/
	.styles([
			  'style.css'
			, 'app.css'
		]
		, 'public/css/all.css'
		, 'public/css/'
		)
	.styles([
			  'front-style.css'
			, 'app.css'
		]
		, 'public/css/main.css'
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
			'resources/assets/images/',
			'public/build/css/images/'
		)
	.copy(
			'resources/assets/bower/datatables/media/images/',
			'public/build/images/'
		)
	.copy(
		   'resources/assets/bower/ckeditor',
		   'public/build/js/ckeditor'
	   )
	.version([
			  'css/all.css'
			, 'js/all.js'
			, 'css/main.css'
			, 'js/main.js'
//            , 'js/custom.js'
		]);
});
