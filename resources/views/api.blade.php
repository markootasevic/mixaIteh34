@extends('layouts.app')

@section('content')




<button onclick="findMovie()">Saznaj broj ljudi u svemiru</button>

<p id="movie"></p>
<p id="people"></p>


<div id="result">
	
</div>

<script type="text/javascript">
	
function findMovie() {
	var name = $('#movie').val();
	 url = 'http://api.open-notify.org/astros.json';
	
	$.ajax({
		type: "GET",
		url: url, 
		success: function(result){
       		// $('#result').html(result);
       		$('#movie').html(result.number);
       		var string = "";
       		jQuery.each(result.people, function(i, val) {
  				string += val.name;
  				string += ', ';
			});
       		$('#people').html(string);
    	},
    	error: function(result){
       		$('#result').html(result);
    	}
});
}

</script>

@stop