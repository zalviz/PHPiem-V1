/*
 *  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a BSD-style license
 *  that can be found in the LICENSE file in the root of the source
 *  tree.
 */

'use strict';
var videobox 	= document.getElementById('outdiv');
var videoElem 	= document.getElementById("video-scanner");
var resultDiv 	= document.getElementById("result");

var width 		= parseInt(videobox.offsetWidth);
var height 		= parseInt(videobox.offsetWidth);
var lastdecode 	= "";

var canvas 		= document.getElementById("canvas-scanner");
canvas.width 	= width;
canvas.height 	= height;

var context 	= canvas.getContext("2d");

var cams = [];
var csi = 0;

var infbox = document.getElementById('infobox');
var restbl = document.getElementById('personal-data');
var btnap = document.getElementById('approve');
var btndec = document.getElementById('decline');
var btnpay = document.getElementById('payfirst');

var btnswitchcam = document.createElement('button');
	btnswitchcam.setAttribute("id", "button-switch-camera");
	btnswitchcam.setAttribute("class", "btn btn-app");
	btnswitchcam.innerHTML = 'Switch Camera';

function ceckdata(tiketcode){
	if (tiketcode == "")
		return;

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
						var qrcodeget = '&code=' + mydata.info['Ticket Code'];
						var usrid = '&uid=' + mydata.info['ID'];
						var btnaphref = '/backpanel/event/1/scan-update';
						btnap.innerHTML = 'Approve';
						btnap.setAttribute('href', btnaphref + '?sec=entrance-venue&src=scanner' + qrcodeget + usrid);

						var btndechref = btndec.getAttribute('href');
						btndec.innerHTML = 'Decline';
						btndec.setAttribute('href', btnaphref + '?sec=entrance-venue&src=scanner' + qrcodeget + usrid);

						btnpay.style.display = 'none';
						infbox.style.display = 'none';
						restbl.innerHTML = "";
						Object.keys(mydata.info).forEach(function(ind){
							var tr = document.createElement('tr');
							tr = restbl.insertRow(-1);
							var tdit = document.createElement('td');
							var tdin = document.createElement('td');
							tdin.innerHTML = ind;
							tdit.innerHTML = (mydata.info[ind] == null) ? ' : ' : ' : ' + mydata.info[ind];
							tr.appendChild(tdin);
							tr.appendChild(tdit);
						});

						if ( mydata.info["Paid Date"] == null && mydata.info["Order Status"] == "Waiting Payment" ) {
							var btnpayhref = btnpay.getAttribute('href');
							btnpay.style.display = 'inline-block';
							btnpay.setAttribute('href', btnaphref + '?sec=payment-accepted&src=scanner' + qrcodeget + usrid);
							btnap.setAttribute("disabled", "disabled");
						}

						infbox.style.display = 'block';
					}
				}
			}
		}
	}
}

function gotDevices(deviceInfos) {
	for (var i = 0; i !== deviceInfos.length; ++i) {
		var deviceInfo = deviceInfos[i];
		if (deviceInfo.kind === 'videoinput') {
			cams[i] = deviceInfo.deviceId;
		}
	}
}

navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

function gotStream(stream) {
	window.stream = stream; // make stream available to console
	videoElem.srcObject = stream;
	// Refresh button list in case labels have become available
	return navigator.mediaDevices.enumerateDevices();
}

function start() {
	if (window.stream) {
		window.stream.getTracks().forEach(function(track) {
			track.stop();
		});
	}
	var videoSource = cams[csi];
	var constraints = {
		audio: false,
		video: {deviceId: videoSource ? {exact: videoSource} : undefined}
	};
	navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
	requestAnimationFrame(tick);
}

function tick(){
	requestAnimationFrame(tick);
	if (videoElem.readyState === videoElem.HAVE_ENOUGH_DATA){
		// Load the video onto the canvas
		context.drawImage(videoElem, 0, 0, width, height);

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

		var decoded = jsQR.decodeQR(rawQR);
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
				myajax = new ActiveXObject(activexmodes[i]);
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
	start();
}

function switchCamera() {
	if ( csi < cams.length-1 ){
		csi++;
	} else {
		csi = 0;
	}
	start();
}

btnpay.onclick = btnScannerOnClick;
btnap.onclick = btnScannerOnClick;
btndec.onclick = btnScannerOnClick;
btnswitchcam.onclick = switchCamera;

start();

function handleError(error) {
	console.log('navigator.getUserMedia error: ', error);
}