{if $dbCalendar->gps_lat && $dbCalendar->gps_lng}
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCjW7uCjwGUAWIp4P4fV6f5TFQ8NkSosWk&sensor=false"></script>
<script type="text/javascript">
                    function initialize() {
					var myLatlng = new google.maps.LatLng({$dbCalendar->gps_lat|replace:',':'.'}, {$dbCalendar->gps_lng|replace:',':'.'});
   			 var myOptions = {
      zoom: 17,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    }
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title:"{$dbCalendar->name}"
    });   }
                  </script>
	{if $dbCalendar->image && false}
		<div id="map_canvas" style="float:left;width:300px; height:250px"></div>
	{else}
		<div id="map_canvas" style="float:left;width:589px; height:500px"></div>
	{/if}
{/if}
