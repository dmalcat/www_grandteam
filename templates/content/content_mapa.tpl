{if $dbCC->gps_lat and $dbCC->gps_lng} 
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCjW7uCjwGUAWIp4P4fV6f5TFQ8NkSosWk&sensor=false"></script> 
<script type="text/javascript">
       function initialize() {
					
		var myLatlng = new google.maps.LatLng({$dbCC->gps_lat|replace:',':'.'}, {$dbCC->gps_lng|replace:',':'.'});
   			 var myOptions = {
      zoom: 17,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    }
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
    var marker = new google.maps.Marker({
        position: myLatlng, 
        map: map,
        title:"{$dbC->title_1}"
    });   } 
	
	function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCjW7uCjwGUAWIp4P4fV6f5TFQ8NkSosWk&sensor=false&' +
            'callback=initialize';
        document.body.appendChild(script);
      }

      window.onload = loadScript;
                  </script>
<div id="map_canvas" style="float:left;width:589px; height:500px"></div>

   
{/if}
