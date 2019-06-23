// This custom.js is used to create some functions to manipulate the system

//login State function
function changeByLoginState(loginState) {
	if (loginState == "false") {
	$("#loginAlert").show();
	$("#loginBtn").show();
	$('button[name*="joinBtn"]').each(function(){
	  $(this).hide();
	}); 
	$("#accountDrop").hide();

	} else {
	$("#loginAlert").hide();
	$("#loginBtn").hide();
	$('button[name*="joinBtn"]').each(function(){
	  $(this).show();
	}); 
	$("#accountDrop").show();
	}
}

//createEventSection() is made for generating event section from JSON file
function createEventSection(resultObj, loginState) {
	$("#mainContent").empty();
	for (i=0,l=resultObj.length; i<l; i++) {
		var eventID = resultObj[i]["eventID"];
		var title = resultObj[i]["name"];
		var cat = resultObj[i]["category"];
		if (cat=="" || cat==null) {cat="Not determined"}
		var org = resultObj[i]["organisation"];
		if (org=="" || org==null) {org="Not determined"}
		var loc = resultObj[i]["location"];
		var dateTime = (resultObj[i]["eventDateTime"]);
		if (dateTime == null || dateTime == "") {
			var date = "";
			var time = "";
		} else {
			var date = dateTime.split(" ")[0];
			var time = (dateTime.split(" ")[1]).slice(0,-3);
		}
		var des = resultObj[i]["description"];
		if(des==null) {des="";}
		
		var imageA = resultObj[i]["image1"];
		if(imageA==null || imageA == "upload/" || imageA =="") {imageA = "img/noimage.png"}

		var eventSection = "<div class='content1' style='background-color:#d3d3d3; margin-bottom:1%; padding:1%;'>\
							<form method='post' action='join.php'>\
								<div class='row' style='margin-bottom: 5%'>\
									<div class='col-8'>\
										<div class='row no-gutters pl20'>\
											<div class='col-12'>\
												<h2 id=title_"+i+">"+title+"</h2>\
											</div>\
										</div>\
										<div class='row no-gutters pl10'>\
											<div class='col-12'>\
												<p>"+des+"</p>\
											</div>\
										</div>\
										<div class='row'>\
											<div class='col-8'>\
												<img src='"+imageA+"' style='margin-top:3%;' class='img-thumbnail' alt='event image' width='400px'>\
											</div>\
											<div class='col-4'>\
												<button name='joinBtn_"+eventID+"' type='submit' class='btn btn-danger' style='display:none; margin-top:100%; margin-bottom:3%;'>J O I N !</button>\
           									</div>\
           								</div>\
           							</div>\
   									<div class='col-4'>\
   										<button type='button' name='"+loc+"' style='margin-top:30%;' class='btn btn-danger btn-lg btn-block' onclick='showMap(event)'> Location\
    									<img src='img/mapLogo.png' width='30px' height='30px' alt='mapLogo' data-toggle='modal' data-target='#mapModal'></button>\
    									<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-primary btn-lg btn-block'>"+cat+"</button>\
    									<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-success btn-lg btn-block'>"+org+"</button>\
	            						<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-info btn-lg btn-block'> Date: "+date+"</button>\
	           							<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-secondary btn-lg btn-block'> Time: "+time+"</button>\
   									</div>\
   									</form>\
       							</div>\
       						<form method='post' action='sendEmail.php'>\
	           					<div class='row' style='padding-bottom:1%;''>\
	           						<div class='col-9'>\
		          						<button name='emailBtn_"+eventID+"' type='submit' class='btn btn-primary' style='width:50%; margin-left:5%''>Email to Organiser</button>\
		        					</div>\
									<div class='col-3'>\
										<div class='fb-share-button' data-href='https://infs3202-e81dce7c.uqcloud.net' data-layout='button' data-size='large' data-mobile-iframe='true'>\
										<a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Finfs3202-e81dce7c.uqcloud.net%2F&amp;src=sdkpreparse' class='fb-xfbml-parse-ignore'></a></div>\
									</div>\
	        					</div>\
	        				</form>\
      						</div>";

		$("#eventLoader").show();
		$("#eventLoader").delay(500).hide(0);
		$("#mainContent").append(eventSection);
	}

	if ($("#mainContent").text() == "") {
		$("#mainContent").append("<div align='center' style='color:red; margin-top:10px;'><h3>No event avilable</h3></div>");
	}

	changeByLoginState(loginState);
}

function searchEvent(loginState) {
	$("#allCat").prop( "checked", true );
	$('[id*="ca"]').each(function() {
		$(this).prop("checked", false);
	});
	var key = jQuery("#searchid").val().toLowerCase();;
	var currentEventData = JSON.parse($("#hiddenSQLdatabase").html());
	var afterSearchArray = [];
	console.log(currentEventData);
	for (i=0,l=currentEventData.length; i<l; i++) {
		var curCat = currentEventData[i]["category"].toLowerCase();
		var curDes = currentEventData[i]["description"].toLowerCase();
		var curNam = currentEventData[i]["name"].toLowerCase();
		var curLoc = currentEventData[i]["location"].toLowerCase();
		var curOrg = currentEventData[i]["organisation"].toLowerCase();
		if ((curCat!="" && curCat.indexOf(key)!==-1 )|| (curDes!="" && curDes.indexOf(key)!==-1 )|| 
			(curNam!="" && curNam.indexOf(key)!==-1 ) || (curLoc!="" && curLoc.indexOf(key)!==-1 ) || (curOrg!="" && curOrg.indexOf(key)!==-1)) {
			afterSearchArray.push(currentEventData[i]);
		}
	}
	$("#mainContent").empty();
	createEventSection(afterSearchArray, loginState);
}

function searchEventByOrg(org, loginState) {
	$("#searchid").prop("value", '');
	$("#allCat").prop( "checked", true );
	$('[id*="ca"]').each(function() {
		$(this).prop("checked", false);
	});
	$("#mainContent").empty();
	var currentEventData = JSON.parse($("#hiddenSQLdatabase").html());
	var afterSearchArray = [];
	for (i=0,l=currentEventData.length; i<l; i++) {
		var curOrg = currentEventData[i]["organisation"];
		if (curOrg!="" && curOrg.indexOf(org)!==-1) {
			afterSearchArray.push(currentEventData[i]);
		}
	}
	createEventSection(afterSearchArray, loginState);
}

function searchEventByCat(cat, loginState) {
	$("#searchid").prop("value", '');
	$("#mainContent").empty();
	var currentEventData = JSON.parse($("#hiddenSQLdatabase").html());
	var afterSearchArray = [];
	for (i=0,l=currentEventData.length; i<l; i++) {
		var curCat = currentEventData[i]["category"];
		if (curCat!="" && curCat.indexOf(cat)!==-1) {
			afterSearchArray.push(currentEventData[i]);
		}
	}
	createEventSection(afterSearchArray, loginState);
}

function resetDB(loginState) {
	var sqlEventData = JSON.parse($("#hiddenSQLdatabase").html());
    createEventSection(sqlEventData, loginState);
}


/* Create my page event lists */
function createEventLists(resultObj, container) {
	$(container).empty();
	for (i=0,l=resultObj.length; i<l; i++) {
		var eventID = resultObj[i]["eventID"];
		var deleteURI = "/INFS/delete.php?eventID=" + eventID;
		var title = resultObj[i]["name"];
		var cat = resultObj[i]["category"];
		if (cat=="" || cat==null) {cat="Not determined"}
		var org = resultObj[i]["organisation"];
		if (org=="" || org==null) {org="Not determined"}
		var loc = resultObj[i]["location"];
		var dateTime = (resultObj[i]["eventDateTime"]);
		if (dateTime == null || dateTime == "") {
			var date = "";
			var time = "";
		} else {
			var date = dateTime.split(" ")[0];
			var time = (dateTime.split(" ")[1]).slice(0,-3);
		}
		var des = resultObj[i]["description"];
		if(des==null) {des="";}
		
		var imageA = resultObj[i]["image1"];
		if(imageA==null || imageA == "upload/" || imageA =="") {imageA = "img/noimage.png"}

		var eventSection = "<div class='content1' style='background-color:#d3d3d3; margin-bottom:1%; padding:1%;'>\
							<form method='post' action='eventDetail.php'>\
								<div class='row' style='margin-bottom: 5%'>\
									<div class='col-8'>\
										<div class='row no-gutters pl20'>\
											<div class='col-12'>\
												<h2 id=title_"+i+">"+title+"</h2>\
											</div>\
										</div>\
										<div class='row no-gutters pl10'>\
											<div class='col-12'>\
												<p>"+des+"</p>\
											</div>\
										</div>\
										<div class='row'>\
											<div class='col-8'>\
												<img src='"+imageA+"' style='margin-top:3%;' class='img-thumbnail' alt='event image' width='400px'>\
											</div>\
											<div class='col-4'>\
												<div class='row'><div class='col-10'><button name='deleteBtn_"+eventID+"' type='button' onclick='setDeleteURI(event)' class='btn btn-danger btn-block' data-toggle='modal' data-target='#deleteModal' style='margin-top:60%; margin-bottom:3%;'>DELETE</button></div></div>\
												<div class='row'><div class='col-10'><button name='editBtn_"+eventID+"' type='submit' class='btn btn-info btn-block ' style='margin-top:20%; margin-bottom:3%;'> EDIT </button></div></div>\
           									</div>\
           								</div>\
           							</div>\
   									<div class='col-4'>\
   										<button type='button' name='"+loc+"' style='margin-top:30%;' class='btn btn-danger btn-lg btn-block' onclick='showMap(event)'> Location\
    									<img src='img/mapLogo.png' width='30px' height='30px' alt='mapLogo' data-toggle='modal' data-target='#mapModal'></button>\
    									<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-primary btn-lg btn-block'>"+cat+"</button>\
    									<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-success btn-lg btn-block'>"+org+"</button>\
	            						<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-info btn-lg btn-block'> Date: "+date+"</button>\
	           							<button type='button' style='margin-top:10%; cursor: default;' class='btn btn-secondary btn-lg btn-block'> Time: "+time+"</button>\
   									</div>\
       							</div>\
	        				</form>\
      						</div>";
      	$(container).append(eventSection);	
	}

	if ($(container).text() == "") {
		$(container).append("<div align='center' style='color:red; margin-top:10px;'><h3>No event avilable</h3></div>");
	}
}

/* Create google map */
function showMap(ev) {
      var locLat;
      var locLng;
      var locName = ev.target.name;
      $('#mapModal').modal('show');
      $('#mapTitle').text(locName);
      locName = locName + " Australia"
      var geocoder =  new google.maps.Geocoder();
        geocoder.geocode( { 'address': locName}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          //console.log(results[0]);
          console.log("location : " + results[0].geometry.location.lat() + " " +results[0].geometry.location.lng());

          locLat = results[0].geometry.location.lat();
          locLng = results[0].geometry.location.lng(); 
          //$("#map").show();
          createMap(locLat, locLng, locName);
        } else {
          alert("Map system cannnot dedect location, sorry " + status);
        }
      });
    };

function createMap(selectedlat, selectedlng, location) {
    console.log("lat: " + selectedlat);
    console.log("lng: " + selectedlng);
    var markerPlace = {lat: selectedlat, lng: selectedlng};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 14,
      center: markerPlace
    });
    var marker = new google.maps.Marker({
      position: markerPlace,
      map: map
    });
    var infowindow = new google.maps.InfoWindow({
        content: location
      });
    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });
  }; 


