var videobox 	= document.getElementById('outdiv'),
	video 		= document.getElementById("video-scanner"),
	resultDiv 	= document.getElementById("result"),
	width 		= parseInt(videobox.offsetWidth),
	height 		= parseInt(videobox.offsetWidth),
	lastdecode 	= "",
	urlobj 		= window.URL || window.webkitURL;
	
var canvas 		= document.getElementById("canvas-scanner");
canvas.width 	= width;
canvas.height 	= height;

var context 	= canvas.getContext("2d"),
	csi 		= 0;
	allsources	= [];

var infbox = document.getElementById('infobox')
	restbl = document.getElementById('personal-data'),
	btnap = document.getElementById('approve'),
	btndec = document.getElementById('decline'),
	btnpay = document.getElementById('payfirst');

var btnswitchcam = document.createElement('button');
	btnswitchcam.setAttribute("id", "button-switch-camera");
	btnswitchcam.setAttribute("class", "btn btn-app");

navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;


function gotSources(sourceInfos) {
	var iv = 0;
	for (var i = 0; i !== sourceInfos.length; ++i) {
		var sourceInfo = sourceInfos[i];
		if (sourceInfo.kind === 'videoinput') {
			allsources[iv] = sourceInfo.deviceId;
			iv++;
		} else {
			console.log('Some other kind of source: ', sourceInfo);
		}
	}

	if (allsources.length > 1) {
		btnswitchcam.style.opacity = 0.7;
		btnswitchcam.position = "absolute";
		btnswitchcam.style.display = "inline-block";
		btnswitchcam.style.zIndex = 1000;
		videobox.appendChild(btnswitchcam);
	}
}

if (typeof MediaStreamTrack === 'undefined' || typeof MediaStreamTrack.getSources === 'undefined') {
	console.log('get nothing devices');
} else {
	alert('we try to display switch camera icon!');
	MediaStreamTrack.getSources(gotSources);
}

function successCallback(stream) {
	window.stream = stream;
	window.stream.stop = function()
	{
		this.getVideoTracks().forEach(function (track) {
			track.stop();
		});
	};
	if (urlobj) {
		video.src = urlobj.createObjectURL(stream);
	} else if (video.mozSrcObject !== undefined) {
		video.mozSrcObject = stream;
	} else {
		video.src = stream;
	}
	video.muted = true;
    video.autoplay = true;
    video.play();
}

function errorCallback(error) {
	console.log('navigator.getUserMedia error: ', error);
}

function start() {
	if (window.stream) {
		video.src = "";
		window.stream.stop();
	}

	var videoSource = allsources[csi];
	var constraints = {
		audio: false,
		video: {
			optional: [{
				sourceId: videoSource
			}]
		}
	};
	navigator.getUserMedia(constraints, successCallback, errorCallback);
	requestAnimationFrame(tick);
}

function vidplay() {
	start();
}

function ceckdata(tiketcode){
	if (tiketcode == "")
		return;

	if (window.stream) {
		video.src = "";
		window.stream.stop();
	}

	var myajax;
	var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
	if (window.ActiveXObject){
		for (var i=0; i<activexmodes.length; i++){
			try{
				myajax = new ActiveXObject(activexmodes[i])
			}
			catch(e){
				console.log('error: ' + e);
			}
		}
	}
	else if (window.XMLHttpRequest)
		myajax = new XMLHttpRequest()
	else
		myajax = false;

	if (myajax != false){
		myajax.open("POST", "/backpanel/event/1/checkin/check-data");
		myajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		myajax.send("ticket_code="+tiketcode);
		myajax.onreadystatechange = function() {
			if (myajax.readyState == 4){
				if (myajax.status==200 || window.location.href.indexOf("http")==-1) {
					var mydata = JSON.parse(myajax.responseText);
					if ( mydata.success ) {
						btnap.innerHTML = 'Approve';
						btndec.innerHTML = 'Decline';
						btnpay.style.display = 'none';
						infbox.style.display = 'none';
						restbl.innerHTML = "";
						Object.keys(mydata.info).forEach(function(ind){
							tr = restbl.insertRow(-1);
							var tdit = document.createElement('td');
							var tdin = document.createElement('td');
							tdin.innerHTML = ind;
							tdit.innerHTML = (mydata.info[ind] == null) ? ' : ' : ' : ' + mydata.info[ind];
							tr.appendChild(tdin);
							tr.appendChild(tdit);
						});

						if ( mydata.info["Paid Date"] == null && mydata.info["Order Status"] == "Waiting Payment" ) {
							btnpay.style.display = 'inline-block';
							btnap.setAttribute("disabled", "disabled");
						}

						infbox.style.display = 'block';
					} else {
						vidplay();
					}
				} else {
					vidplay();
				}
			} else {
				vidplay();
			}
		}
	} else {
		vidplay();
	}
}

function tick(){
	requestAnimationFrame(tick);
	if (video.readyState === video.HAVE_ENOUGH_DATA){
		// Load the video onto the canvas
		context.drawImage(video, 0, 0, width, height);

		// Load the image data from the canvas
		var imageData = context.getImageData(0, 0, width, height);
		var binarizedImage = jsQR.binarizeImage(imageData.data, imageData.width, imageData.height);
		var location = jsQR.locateQRInBinaryImage(binarizedImage);

		if (!location){
			resultDiv.innerHTML = "<div style='color: red; margin:15px;'>Waiting QR code image...</div>";
			return;
		}

		var rawQR = jsQR.extractQRFromBinaryImage(binarizedImage, location);
		if (!rawQR) {
			resultDiv.innerHTML = "<div style='color: red; margin:15px;'>Try other position...</div>";
			return;
		}

		decoded = jsQR.decodeQR(rawQR);
		if (decoded && lastdecode != decoded) {
			resultDiv.innerHTML = "<div style='color: green; margin:15px;'>QR Decoded! <span style='color: #000;'>"+decoded+"</span></div>";
			context.beginPath();

			context.moveTo(location.bottomLeft.x, location.bottomLeft.y);
			context.lineTo(location.topLeft.x, location.topLeft.y);
			context.lineTo(location.topRight.x, location.topRight.y);
			context.lineWidth = 4;
			context.strokeStyle = "green";
			context.stroke();
			ceckdata(decoded);
		} else {
			resultDiv.innerHTML = "<div style='color: red; margin:15px;'>Tyr another QR code image...</div>";
		}
	}
}

function updatescanner($url) {
	var myajax;
	var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
	if (window.ActiveXObject){
		for (var i=0; i<activexmodes.length; i++){
			try{
				myajax = new ActiveXObject(activexmodes[i])
			}
			catch(e){
				console.log('error: ' + e);
			}
		}
	}
	else if (window.XMLHttpRequest)
		myajax = new XMLHttpRequest()
	else
		myajax = false;

	if (myajax != false){
		myajax.open("GET", $url);
		myajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		myajax.onreadystatechange = function() {
			if (myajax.readyState == 4){
				if (myajax.status==200 || window.location.href.indexOf("http")==-1) {
					var mydata = JSON.parse(myajax.responseText);
					if ( mydata.success ) {}
				}
			}
		}
	}
}

function btnScannerOnClick(e) {
	e.preventDefault();
	if (this.getAttribute("href") !== "#")
		updatescanner(this.getAttribute("href"));
	restbl.innerHTML = "";
	infbox.style.display = 'none';
	vidplay();
}

function switchCamera() {
	if (window.stream) {
		video.src = "";
		window.stream.stop();
	}

	if ( csi < allsources.length-1 ){
		csi++;
	} else {
		csi = 0;
	}
	vidplay();
}

btnpay.onclick = btnScannerOnClick;
btnap.onclick = btnScannerOnClick;
btndec.onclick = btnScannerOnClick;
btnswitchcam.onclick = switchCamera;

start();