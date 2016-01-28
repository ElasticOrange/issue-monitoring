(function(){
	$(document).ready(function(){
		$('[data-confirm=true]').click(function(e)
		{
			if(confirm('Vrei sa stergi acest document ?'))
			{
				return true;
			}
			e.preventDefault();
			return false;
		});


		var dateWidgets = $('[date-widget=true]').datetimepicker({
			locale: 'ro',
			format: 'L',
			defaultDate: moment()
		});

		$('[name=date]').val(($('[date-widget=true]').val()).split(".").reverse().join("-"));

		dateWidgets.on('dp.change', function () {
			var d = $(this).data("DateTimePicker").date();
			var e = d.format("YYYY-MM-DD");
			$('[name=date]').val(e);
		});
	});
})();
