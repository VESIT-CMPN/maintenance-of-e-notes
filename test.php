<!DOCTYPE html>
<html>
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body onload="init();">
    <h1>Take a snapshot of the current video stream</h1>
   Click on the Start WebCam button.
     <p>
    <button onclick="startWebcam();">Start WebCam</button>
    <button onclick="stopWebcam();">Stop WebCam</button> 
       <button onclick="snapshot();">Take Snapshot</button> 
    </p>
    <video onclick="snapshot(this);" width=400 height=400 id="video" controls autoplay></video>
  <p>

        Screenshots : <p>
      <canvas  id="myCanvas" width="400" height="350"></canvas> 
      <a id="download">Download as image</a> 

      <form method="post" accept-charset="utf-8" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden"/>
      </form>
  </body>
  <script>
function uploadEx() {
                var canvas = document.getElementById("myCanvas");
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
                var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_data.php', true);
 
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        alert('Succesfully uploaded');
                    }
                };
 
                xhr.onload = function() {
 
                };
                xhr.send(fd);
            };

      /**
 *    Ken Fyrstenberg Nilsen
 *    Abidas Software
*/
var canvas = document.getElementById('myCanvas'),
    ctx = canvas.getContext('2d');

/**
 * Demonstrates how to download a canvas an image with a single
 * direct click on a link.
 */
function doCanvas() {
    /* draw something */
    ctx.fillStyle = '#f90';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#fff';
    ctx.font = '60px sans-serif';
    ctx.fillText('Code Project', 10, canvas.height / 2 - 15);
    ctx.font = '26px sans-serif';
    ctx.fillText('Click link below to save this as image', 15, canvas.height / 2 + 35);
}

/**
 * This is the function that will take care of image extracting and
 * setting proper filename for the download.
 * IMPORTANT: Call it from within a onclick event.
*/
function downloadCanvas(link, canvasId, filename) {
    link.href = document.getElementById(canvasId).toDataURL();
    link.download = filename;
}

/** 
 * The event handler for the link's onclick event. We give THIS as a
 * parameter (=the link element), ID of the canvas and a filename.
*/
document.getElementById('download').addEventListener('click', function() {
    downloadCanvas(this, 'myCanvas', 'test.png');
}, false);


      //--------------------
      // GET USER MEDIA CODE
      //--------------------
          navigator.getUserMedia = ( navigator.getUserMedia ||
                             navigator.webkitGetUserMedia ||
                             navigator.mozGetUserMedia ||
                             navigator.msGetUserMedia);

      var video;
      var webcamStream;

      function startWebcam() {
        if (navigator.getUserMedia) {
           navigator.getUserMedia (

              // constraints
              {
                 video: true,
                 audio: false
              },

              // successCallback
              function(localMediaStream) {
                  video = document.querySelector('video');
                 video.src = window.URL.createObjectURL(localMediaStream);
                 webcamStream = localMediaStream;
              },

              // errorCallback
              function(err) {
                 console.log("The following error occured: " + err);
              }
           );
        } else {
           console.log("getUserMedia not supported");
        }  
      }

      function stopWebcam() {
          webcamStream.stop();
      }
      //---------------------
      // TAKE A SNAPSHOT CODE
      //---------------------
      var canvas, ctx;

      function init() {
        // Get the canvas and obtain a context for
        // drawing in it
        canvas = document.getElementById("myCanvas");
        ctx = canvas.getContext('2d');
      }

      function snapshot() {
         // Draws current image from the video element into the canvas
        ctx.drawImage(video, 0,0, canvas.width, canvas.height);
        uploadEx();
        //document.getElementById("download").click();
      }


  </script>
</html>
