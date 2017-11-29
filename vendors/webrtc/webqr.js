// QRCODE reader Copyright 2011 Lazar Laszlo
// http://www.webqr.com

var gCtx = null;
var gCanvas = null;
var c = 0;
var stype = 0;
var gUM = false;
var webkit = false;
var moz = false;
var v = null;

var imghtml = '<canvas id="out-canvas" width="320" height="240"></canvas>';
var vidhtml = '<video id="v" autoplay></video>';

function initCanvas(w, h)
{
    gCanvas = document.getElementById("qr-canvas");
    gCanvas.style.width = w + "px";
    gCanvas.style.height = h + "px";
    gCanvas.width = w;
    gCanvas.height = h;
    gCtx = gCanvas.getContext("2d");
    gCtx.clearRect(0, 0, w, h);
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function readqr(a)
{
    var html = "<br>";
    if(a.indexOf("http://") === 0 || a.indexOf("https://") === 0)
        html+="<a target='_blank' href='"+a+"'>"+a+"</a><br>";

    html += "<b>" + htmlEntities(a) + "</b><br><br>";
    document.getElementById("result").innerHTML = html;
}

function isCanvasSupported(){
    var elem = document.createElement('canvas');
    return !!(elem.getContext && elem.getContext('2d'));
}

function captureToCanvas() {
    if(stype != 1)
        return;

    if(gUM)
    {
        try{
            gCtx.drawImage(v, 0, 0, 800, 600);
            try {
                qrcode.decode();
            }
            catch(e){
                // console.log(e);
                setTimeout(captureToCanvas, 500);
            };
        }
        catch(e){
            // console.log(e);
            setTimeout(captureToCanvas, 500);
        };
    }
}

function success(stream) {
    if(webkit)
        v.src = window.URL.createObjectURL(stream);
    else if(moz)
    {
        v.mozSrcObject = stream;
        v.play();
    }
    else
        v.src = stream;

    gUM = true;
    setTimeout(captureToCanvas, 500);
}

function error(error) {
    gUM = false;
    return;
}

function setwebcam2(options)
{
    document.getElementById("result").innerHTML = "<br>- scanning -";
    if(stype == 1)
    {
        setTimeout(captureToCanvas, 500);
        return;
    }

    var n = navigator;
    document.getElementById("outdiv").innerHTML = vidhtml;
    v = document.getElementById("v");

    if(n.getUserMedia)
    {
        webkit = true;
        n.getUserMedia({video: options, audio: false}, success, error);
    }
    else if(n.webkitGetUserMedia)
    {
        webkit = true;
        n.webkitGetUserMedia({video:options, audio: false}, success, error);
    }
    else if(n.mozGetUserMedia)
    {
        moz = true;
        // console.log(n.mediaDevices.getUserMedia({video: options, audio: false}));
        n.mediaDevices.getUserMedia({video: options, audio: false}).then(success).catch(error);
    }

    stype = 1;
    setTimeout(captureToCanvas, 500);
}

function setwebcam()
{
    var options = true;
    if(navigator.mediaDevices && navigator.mediaDevices.enumerateDevices)
    {
        try {
			navigator.mediaDevices.enumerateDevices().then(function(devices) {
                devices.forEach(function(device) {
                    if (device.kind === 'videoinput') {
                        if(device.label.toLowerCase().search("back") >-1)
                            options = {'deviceId': {'exact':device.deviceId}, 'facingMode':'environment'};
                    }
                });
                setwebcam2(options);
            });
        }
        catch(e)
		{
            console.log(e);
		}
	}
	else {
        setwebcam2(options);
	}
}

function scannerLoad()
{
    if(isCanvasSupported() && window.File && window.FileReader)
    {
        initCanvas(800, 600);
        qrcode.callback = readqr;
        setwebcam();
    }
    else
    {
        document.getElementById("result").innerHTML = '<p>sorry your browser is not supported</p>';
    }
}

document.addEventListener("DOMContentLoaded", scannerLoad );