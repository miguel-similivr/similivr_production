(function() {

  var scripts = document.getElementsByTagName('script');
  var index = scripts.length - 1;
  var myScript = scripts[index];

  var contentId = getParameterByName('id', myScript.src);
  var contentUser = getParameterByName('user', myScript.src);
  var assetUrl = null;

  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  // Localize jQuery variable
  var jQuery;

  /******** Load jQuery if not present *********/
  if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.4.2') {
      var script_tag = document.createElement('script');
      script_tag.setAttribute("type","text/javascript");
      script_tag.setAttribute("src",
          "https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
      if (script_tag.readyState) {
        script_tag.onreadystatechange = function () { // For old versions of IE
            if (this.readyState == 'complete' || this.readyState == 'loaded') {
                scriptLoadHandler();
            }
        };
      } 

      else { // Other browsers
        script_tag.onload = scriptLoadHandler;
      }
      // Try to find the head, otherwise default to the documentElement
      (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
  } 

  else {
      // The jQuery version on the window is the one we want to use
      jQuery = window.jQuery;
      main();
  }

  /******** Called once jQuery has loaded ******/
  function scriptLoadHandler() {
      // Restore $ and window.jQuery to their previous values and store the
      // new jQuery in our local jQuery variable
      jQuery = window.jQuery.noConflict(true);
      // Call our main function
      main(); 
  }

  /******** Our main function ********/
  function main() { 
      jQuery(document).ready(function($) {
        // We can use jQuery 1.4.2 here
        "use strict";

        var contentUrl = '';

        $.getScript("player/output.min.js", function(){
          var vrDisplay = null;
          var projectionMat = mat4.create();
          var poseMat = mat4.create();
          var viewMat = mat4.create();
          var vrPresentButton = null;
          var nextButton = null;
          // ================================================================
          // WebGL and WebAudio scene setup. This code is not WebVR specific.
          // ================================================================

          // WebGL setup.
          var playerContainer = document.getElementById("similivr-player-container-"+contentUser+"-"+contentId);
          var webglCanvas = document.getElementById("webgl-canvas");
          if (!webglCanvas) {
            webglCanvas = document.createElement("canvas");
            webglCanvas.id = "webgl-canvas";
            playerContainer.appendChild(webglCanvas);
          }
          var gl = null;
          var panorama = null;

          var fullscreen = false;

          function init (preserveDrawingBuffer) {
            var glAttribs = {
              alpha: false,
              antialias: false,
              preserveDrawingBuffer: preserveDrawingBuffer
            };
            gl = webglCanvas.getContext("webgl", glAttribs);
            gl.enable(gl.DEPTH_TEST);
            gl.enable(gl.CULL_FACE);

            panorama = new VRPanorama(gl);
            panorama.setImage(contentUrl);
              
            //For FPS Stats
            //stats = new WGLUStats(gl);

            // Wait until we have a WebGL context to resize and start rendering.
            window.addEventListener("resize", onResize, false);
            onResize();
            window.requestAnimationFrame(onAnimationFrame);
          }

          // ================================
          // WebVR-specific code begins here.
          // ================================
          function getButtonContainer () {
            var buttonContainer = document.getElementById("similivr-player-container-"+contentUser+"-"+contentId);
            return buttonContainer;
          }

          function addButtonElement (message, key, icon, type) {
            var buttonElement = document.createElement("div");
            buttonElement.classList.add = "similivr-player-button";
            buttonElement.classList.add = type;
            buttonElement.style.color = "#FFF";
            buttonElement.style.fontWeight = "normal";
            buttonElement.style.backgroundColor = "#888";
            buttonElement.style.backgroundColor = "rgba(0, 0, 0, 0.3)";
            buttonElement.style.borderRadius = "0px";
            buttonElement.style.border = "none";
            buttonElement.style.position = "absolute";
            buttonElement.style.display = "inline-block";
            buttonElement.style.margin = "0.5em";
            buttonElement.style.padding = "0.75em";
            buttonElement.style.cursor = "pointer";
            buttonElement.align = "center";

            if (type == "similivr-button-togglevr") {
              buttonElement.style.bottom = "0";
              buttonElement.style.right = "0";
            }
            if (type == "similivr-button-fullscreen") {
              buttonElement.style.top = "0";
              buttonElement.style.left = "0";
            }
            if (type == "similivr-button-reset") {
              buttonElement.style.bottom = "0";
              buttonElement.style.left = "0";
            }

            if (icon) {
              buttonElement.innerHTML = "<img src='" + icon + "'/><br/>" + message;
            } else {
              buttonElement.innerHTML = message;
            }

            if (key) {
              var keyElement = document.createElement("span");
              keyElement.classList.add = "similivr-button-accelerator";
              keyElement.style.fontSize = "0.75em";
              keyElement.style.fontStyle = "italic";
              keyElement.innerHTML = " (" + key + ")";

              buttonElement.appendChild(keyElement);
            }

            getButtonContainer().appendChild(buttonElement);

            return buttonElement;
          }

          function addButton (message, key, icon, type, callback) {
            var keyListener = null;
            if (key) {
              var keyCode = key.charCodeAt(0);
              keyListener = function (event) {
                if (event.keyCode === keyCode) {
                  callback(event);
                }
              };
              document.addEventListener("keydown", keyListener, false);
            }
            var element = addButtonElement(message, key, icon, type);
            element.addEventListener("click", function (event) {
              callback(event);
              event.preventDefault();
            }, false);

            return {
              element: element,
              keyListener: keyListener
            };
          }

          function removeButton (button) {
            if (!button)
              return;
            if (button.element.parentElement)
              button.element.parentElement.removeChild(button.element);
            if (button.keyListener)
              document.removeEventListener("keydown", button.keyListener, false);
          }

          function entFullScreen () {
            if (playerContainer.requestFullscreen) {
                playerContainer.requestFullscreen();
              } else if (playerContainer.webkitRequestFullscreen) {
                playerContainer.webkitRequestFullscreen();
              } else if (playerContainer.mozRequestFullScreen) {
                playerContainer.mozRequestFullScreen();
              } else if (playerContainer.msRequestFullscreen) {
                playerContainer.msRequestFullscreen();
              }

            fullscreen = true;
          }

          function extFullScreen () {
            if (document.exitFullscreen) {
                document.exitFullscreen();
              } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
              } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
              } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
              }
            fullscreen = false;
          }

          function onSizeToggle () {
            if (fullscreen == false) {
              entFullScreen();
              init(true);
            }

            else {
              extFullScreen();
              init(true);
            }

          }

          function onVRRequestPresent () {
            if (fullscreen) {
              extFullScreen().done( function() {
                vrDisplay.requestPresent([{ source: webglCanvas }]).then(function () {
                }, function () {
                  VRSamplesUtil.addError("requestPresent failed.", 2000);
                })});
            } else {
              vrDisplay.requestPresent([{ source: webglCanvas }]).then(function () {
              }, function () {
                VRSamplesUtil.addError("requestPresent failed.", 2000);
              });
            }
          }

          function onVRExitPresent () {
            vrDisplay.exitPresent().then(function () {
            }, function () {
              VRSamplesUtil.addError("exitPresent failed.", 2000);
            });
          }

          function onVRPresentChange () {
            onResize();

            if (vrDisplay.isPresenting) {
              if (vrDisplay.capabilities.hasExternalDisplay) {
                VRSamplesUtil.removeButton(vrPresentButton);
                vrPresentButton = addButton("Exit VR", "E", "media/icons/cardboard64.png", "similivr-button-togglevr", onVRExitPresent);
              }
            } else {
              if (vrDisplay.capabilities.hasExternalDisplay) {
                VRSamplesUtil.removeButton(vrPresentButton);
                vrPresentButton = addButton("Enter VR", "E", "media/icons/cardboard64.png", "similivr-button-togglevr", onVRRequestPresent);
              }
            }
          }

          if (navigator.getVRDisplays) {
            navigator.getVRDisplays().then(function (displays) {
              if (displays.length > 0) {
                vrDisplay = displays[0];
                $.get("player/getcontenturl.php", { id:contentId, user:contentUser }, function(res) { 
                  contentUrl = res;
                  init(true);
                });

                addButton("Fullscreen", "Z", null, "similivr-button-fullscreen", onSizeToggle);

                if (!vrDisplay.stageParameters) {
                  addButton("Reset Pose", "R", null, "similivr-button-reset", function () { vrDisplay.resetPose(); });
                }

                if (vrDisplay.capabilities.canPresent)
                  vrPresentButton = addButton("Enter VR", "E", "media/icons/cardboard64.png", "similivr-button-togglevr", onVRRequestPresent);

                window.addEventListener('vrdisplaypresentchange', onVRPresentChange, false);
              } else {
                init(false);
                VRSamplesUtil.addInfo("WebVR supported, but no VRDisplays found.", 3000);
              }
            });
          } else if (navigator.getVRDevices) {
            init(false);
            VRSamplesUtil.addError("Your browser supports WebVR but not the latest version. See <a href='http://webvr.info'>webvr.info</a> for more info.");
          } else {
            init(false);
            VRSamplesUtil.addError("Your browser does not support WebVR. See <a href='http://webvr.info'>webvr.info</a> for assistance.");
          }

          function onResize () {
            if (vrDisplay && vrDisplay.isPresenting) {
              var leftEye = vrDisplay.getEyeParameters("left");
              var rightEye = vrDisplay.getEyeParameters("right");

              webglCanvas.width = Math.max(leftEye.renderWidth, rightEye.renderWidth) * 2;
              webglCanvas.height = Math.max(leftEye.renderHeight, rightEye.renderHeight);
            } else {
              webglCanvas.width = webglCanvas.offsetWidth * window.devicePixelRatio;
              webglCanvas.height = webglCanvas.offsetHeight * window.devicePixelRatio;
            }
          }

          function getPoseMatrix (out, pose) {
            // When rendering a panorama ignore the pose position. You want the
            // users head to stay centered at all times. This would be terrible
            // advice for any other type of VR scene, by the way!
            var orientation = pose.orientation;
            if (!orientation) { orientation = [0, 0, 0, 1]; }
            mat4.fromQuat(out, orientation);
          }

          function renderSceneView (poseInMat, eye) {
            if (eye) {
              // FYI: When rendering a panorama do NOT offset the views by the IPD!
              // That will make the viewer feel like their head is trapped in a tiny
              // ball, which is usually not the desired effect.
              mat4.perspectiveFromFieldOfView(projectionMat, eye.fieldOfView, 0.1, 1024.0);
              mat4.invert(viewMat, poseInMat);
            } else {
              mat4.perspective(projectionMat, Math.PI*0.4, webglCanvas.width / webglCanvas.height, 0.1, 1024.0);
              mat4.invert(viewMat, poseInMat);
            }

            panorama.render(projectionMat, viewMat);
          }

          function onAnimationFrame (t) {
            //For FPS stats
            //stats.begin();

            gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

            if (vrDisplay) {
              vrDisplay.requestAnimationFrame(onAnimationFrame);

              var pose = vrDisplay.getPose();
              getPoseMatrix(poseMat, pose);

              if (vrDisplay.isPresenting) {
                gl.viewport(0, 0, webglCanvas.width * 0.5, webglCanvas.height);
                renderSceneView(poseMat, vrDisplay.getEyeParameters("left"));

                gl.viewport(webglCanvas.width * 0.5, 0, webglCanvas.width * 0.5, webglCanvas.height);
                renderSceneView(poseMat, vrDisplay.getEyeParameters("right"));

                vrDisplay.submitFrame(pose);
              } else {
                gl.viewport(0, 0, webglCanvas.width, webglCanvas.height);
                renderSceneView(poseMat, null);
                //stats.renderOrtho();
              }
            } else {
              window.requestAnimationFrame(onAnimationFrame);

              // No VRDisplay found.
              gl.viewport(0, 0, webglCanvas.width, webglCanvas.height);
              mat4.perspective(projectionMat, Math.PI*0.4, webglCanvas.width / webglCanvas.height, 0.1, 1024.0);
              mat4.identity(viewMat);
              panorama.render(projectionMat, viewMat);

              //stats.renderOrtho();
            }

            //stats.end();
          
          }
        //END OF WEBVR CODE
        });
      });
  }

})(); // We call our anonymous function immediately
