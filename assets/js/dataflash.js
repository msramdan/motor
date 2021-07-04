const flasData = $('.flash-data').data('flashdata'); //dataflash ini harus di panggil di fofter ex lane 182 footer


if(flasData){
	Swal.fire(
	  'Terima Kasih',
	  flasData,
	  'success'
	)
}

