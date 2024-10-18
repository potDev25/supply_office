<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"
        integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        #sig-canvas {
            border: 2px dotted #CCCCCC;
            border-radius: 15px;
            cursor: crosshair;
        }
    </style>
</head>

<body>
    <!-- Content -->
    <form class="container" id="form_sig" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <h4>Draw your E-Signature</h4>
                <p>Sign in the canvas below and save your signature as an image!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <canvas id="sig-canvas" width="620" height="160">
                    Get a better browser, bro.
                </canvas>
            </div>
            <span id="image_Error" class="error text-danger text-sm mb-3"></span>
        </div>
        <br />
        <div class="col-md-4">
            <input id="sig-dataUrl" name="image" class="form-control d-none" rows="5"/>
        </div>
        <div class="row">
            <div class="col-md-8">
                <label for="" class="form-label">Enter Name</label>
                <input type="text" name="name" class="form-control">
                <span id="name_Error" class="error text-danger text-sm mb-3"></span>
            </div>
        </div>
        <br />
        <div class="row d-none">
            <div class="col-md-12">
                <img id="sig-image" src="" alt="Your signature will go here!" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" id="sig-submitBtn">Submit Signature</button>
                <button type="button" class="btn btn-default" id="sig-clearBtn">Clear Signature</button>
            </div>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"
        integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        (function() {
            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window
                    .mozRequestAnimationFrame || window.oRequestAnimationFrame || window
                    .msRequestAnimaitonFrame || function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    }

                ;
            })();

            var canvas = document.getElementById("sig-canvas");
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#222222";
            ctx.lineWidth = 4;

            var drawing = false;

            var mousePos = {
                x: 0,
                y: 0
            }

            ;
            var lastPos = mousePos;

            canvas.addEventListener("mousedown", function(e) {
                    drawing = true;
                    lastPos = getMousePos(canvas, e);
                }

                , false);

            canvas.addEventListener("mouseup", function(e) {
                    drawing = false;
                }

                , false);

            canvas.addEventListener("mousemove", function(e) {
                    mousePos = getMousePos(canvas, e);
                }

                , false);

            // Add touch event support for mobile
            canvas.addEventListener("touchstart", function(e) {}

                , false);

            canvas.addEventListener("touchmove", function(e) {
                    var touch = e.touches[0];

                    var me = new MouseEvent("mousemove", {
                        clientX: touch.clientX,
                        clientY: touch.clientY
                    });
                    canvas.dispatchEvent(me);
                }

                , false);

            canvas.addEventListener("touchstart", function(e) {
                    mousePos = getTouchPos(canvas, e);
                    var touch = e.touches[0];

                    var me = new MouseEvent("mousedown", {
                        clientX: touch.clientX,
                        clientY: touch.clientY
                    });
                    canvas.dispatchEvent(me);
                }

                , false);

            canvas.addEventListener("touchend", function(e) {
                    var me = new MouseEvent("mouseup", {});
                    canvas.dispatchEvent(me);
                }

                , false);

            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();

                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                }
            }

            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();

                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                }
            }

            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                    if (e.target == canvas) {
                        e.preventDefault();
                    }
                }

                , false);

            document.body.addEventListener("touchend", function(e) {
                    if (e.target == canvas) {
                        e.preventDefault();
                    }
                }

                , false);

            document.body.addEventListener("touchmove", function(e) {
                    if (e.target == canvas) {
                        e.preventDefault();
                    }
                }

                , false);

            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");

            sigText.value = ''

            clearBtn.addEventListener("click", function(e) {
                    clearCanvas();
                    sigText.innerHTML = "Data URL for your signature will go here!";
                    sigImage.setAttribute("src", "");
                }

                , false);

            document.getElementById('form_sig').addEventListener("submit", async function(e) {
                    e.preventDefault()
                    submitBtn.innerHTML = 'Loading....'
                    var dataUrl = canvas.toDataURL();
                    sigText.value = dataUrl;
                    sigImage.setAttribute("src", dataUrl);

                    const form = e.target
                    const formData = new FormData(form)

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    console.log(csrfToken);
                    
                    try {
                        const response = await fetch('http://127.0.0.1:8000/signature/store', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken, // Include the CSRF token
                                'Accept': 'application/json'
                            },
                            body: formData,
                            credentials: 'include'
                        });

                        if (!response.ok) {
                            if (response.status === 422) {
                                // Handle validation errors
                                const errorData = await response.json().catch(() => {
                                    throw new Error('Invalid JSON response');
                                });

                                const errors = errorData.errors;

                                // Display the validation errors
                                for (const [key, messages] of Object.entries(errors)) {
                                    const errorSpan = document.getElementById(`${key}_Error`);
                                    if (errorSpan) {
                                        errorSpan.textContent = messages.join(' ');
                                    }
                                }
                            } else {
                                throw new Error('Network response was not ok');
                            }
                        } else {
                            const data = await response.json().catch(() => {
                                throw new Error('Invalid JSON response');
                            });

                            if (data.success) {
                                // window.location.replace('/admin/users');
                            } else {
                                alert('Server error');
                            }
                        }
                        sigText.value = ""

                        console.log(response);

                    } catch (error) {

                    }

                }

                , false);

        })();
    </script>

</body>

</html>
