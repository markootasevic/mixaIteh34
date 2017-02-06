@extends('layouts.app')

@section('style')

	

@stop

@section('content')
		

		<div style="height:400px; width: 400px;">
		<div id="map" style="height:400px; width: 400px;"></div>
		</div>


	<script type="text/javascript">
		
		 function initMap() {
        var position = {lat: 44.775652, lng: 20.482224};
            map = new google.maps.Map(document.getElementById('map'), {
            center: position,
            zoom: 15,
        });

        var marker = new google.maps.Marker({
            position: position,
            map: map,
            title: 'There we are!',
            icon: "{{ URL::asset('img/marker.png') }}"
            
        });
      }
     

	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7n1gFAy_Kl_E1vmQ4-ALfLj6JNNQn10w&callback=initMap"
	async defer></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#map").removeAttr("style");	
		});
		
	</script>

@stop