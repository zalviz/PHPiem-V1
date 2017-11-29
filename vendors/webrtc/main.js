/*
 *  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a BSD-style license
 *  that can be found in the LICENSE file in the root of the source
 *  tree.
 */

// 'use strict';

// // Put variables in global scope to make them available to the browser console.
// var video = document.querySelector('video');
// var canvas = window.canvas = document.querySelector('canvas');
// canvas.width = 480;
// canvas.height = 360;

// var button = document.querySelector('button');
// button.onclick = function() {
// 	canvas.width = video.videoWidth;
// 	canvas.height = video.videoHeight;
// 	canvas.getContext('2d').
// 	drawImage(video, 0, 0, canvas.width, canvas.height);
// };

// var constraints = {
// 	audio: false,
// 	video: true
// };

// function handleSuccess(stream) {
// 	window.stream = stream; // make stream available to browser console
// 		video.srcObject = stream;
// }

// function handleError(error) {
// 	console.log('navigator.getUserMedia error: ', error);
// }

// navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);
// 
window.onload = function() {
	var video = document.getElementById('video-scanner');
	var canvas = document.getElementById('canvas-scanner');
	var res = document.getElementById('result');

	canvas.width = video.offsetWidth;
	canvas.height = video.offsetHeight;

	var context = canvas.getContext('2d');
	var tracker = new tracking.ObjectTracker('qrc03');
	tracker.setInitialScale(4);
	tracker.setStepSize(2);
	tracker.setEdgesDensity(0.1);

	tracking.track('#video-scanner', tracker, { camera: true });

	tracker.on('track', function(event) {
		context.clearRect(0, 0, canvas.width, canvas.height);
		console.log(event.data);
		event.data.forEach(function(rect) {
			context.strokeStyle = '#a64ceb';
			context.strokeRect(rect.x, rect.y, rect.width, rect.height);
			res.innerHTML = 'x: ' + rect.x + 'px y: ' + rect.y + 'px lebar: ' + rect.width + ' px tinggi: ' + rect.height + 'px';
		});
	});
};