<div class="container pt-3">
    <div class="row justify-content-center">
        <div class="col-12 vh-100 d-flex flex-column align-items-center mt-5">
            <h5 class="mb-3">Teachable Machine Image Model</h5>

            <div class="d-flex gap-2 mb-3">
                <button type="button" id="webcamBtn" class="btn btn-primary">Start Camera</button>
                <button type="button" id="uploadBtn" class="btn btn-secondary">Upload Image</button>
                <input type="file" id="imageUpload" accept="image/*" style="display:none">
            </div>

            <div id="webcam-container" class="mb-2"></div>
            <div id="upload-preview" class="mb-2" style="display:none">
                <img id="uploaded-image" style="width:200px; height:200px; object-fit:cover;" />
            </div>

            <div id="label-container" class="w-100" style="max-width: 400px;"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
<script type="text/javascript">
    // const URL = "/ai/my_model/";
    const URL = "/ai/chartD/";

    let model, webcam, maxPredictions;
    let isRunning = false;
    let animationFrame = null;

    // --- jQuery Events ---
    $(document).ready(function () {
        renderScoreboard([]);

        $("#webcamBtn").on("click", function () {
            if (isRunning) {
                stopWebcam();
            } else {
                startWebcam();
            }
        });

        $("#uploadBtn").on("click", function () {
            $("#imageUpload").val("").trigger("click");
        });

        $("#imageUpload").on("change", function (event) {
            handleImageUpload(event);
        });
    });

    // --- Load Model ---
    async function loadModel() {
        if (!model) {
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();
        }
    }

    // --- Scoreboard ---
    function renderScoreboard(predictions) {
        if (!predictions.length) {
            $("#label-container").html(`
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center fw-bold fs-5">
                        🏆 Scoreboard
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center text-muted py-3">
                            📷 Open Camera / Upload Image
                        </li>
                    </ul>
                </div>`);
            return;
        }

        const sorted = [...predictions].sort((a, b) => b.probability - a.probability);
        const colors = ["success", "primary", "warning", "danger", "info", "secondary"];
        const medals = ["🥇", "🥈", "🥉"];

        const rows = sorted.map((p, i) => {
            const pct = (p.probability * 100).toFixed(1);
            const color = colors[i % colors.length];
            const medal = medals[i] ?? `#${i + 1}`;
            const isTop = i === 0;

            return `
                <li class="list-group-item ${isTop ? "bg-light" : ""}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold">${medal} ${p.className}</span>
                        <span class="badge bg-${color} fs-6">${pct}%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-${color} ${isTop ? "progress-bar-striped progress-bar-animated" : ""}"
                            role="progressbar"
                            style="width: ${pct}%"
                            aria-valuenow="${pct}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </li>`;
        }).join("");

        $("#label-container").html(`
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center fw-bold fs-5">
                    🏆 Scoreboard
                </div>
                <ul class="list-group list-group-flush">
                    ${rows}
                </ul>
            </div>`);
    }

    // --- Webcam ---
    async function startWebcam() {
        await loadModel();

        $("#upload-preview").hide();

        const flip = true;
        webcam = new tmImage.Webcam(200, 200, flip);
        await webcam.setup();
        await webcam.play();

        $("#webcam-container").empty().append(webcam.canvas);

        isRunning = true;
        updateBtn();
        loop();
    }

    function stopWebcam() {
        if (webcam) {
            webcam.stop();
            webcam = null;
        }
        if (animationFrame) {
            cancelAnimationFrame(animationFrame);
            animationFrame = null;
        }

        $("#webcam-container").empty();
        renderScoreboard([]);

        isRunning = false;
        updateBtn();
    }

    function updateBtn() {
        const $btn = $("#webcamBtn");
        if (isRunning) {
            $btn.text("Stop Camera").removeClass("btn-primary").addClass("btn-danger");
        } else {
            $btn.text("Start Camera").removeClass("btn-danger").addClass("btn-primary");
        }
    }

    async function loop() {
        if (!isRunning) return;
        webcam.update();
        await predict(webcam.canvas);
        animationFrame = window.requestAnimationFrame(loop);
    }

    // --- Image Upload ---
    async function handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        await loadModel();

        if (isRunning) stopWebcam();

        const reader = new FileReader();
        reader.onload = function (e) {
            $("#uploaded-image").attr("src", e.target.result);
            $("#upload-preview").show();

            $("#uploaded-image").on("load", async function () {
                await predict($("#uploaded-image")[0]);
            });
        };

        reader.readAsDataURL(file);
    }

    // --- Predict ---
    async function predict(source) {
        const prediction = await model.predict(source);
        renderScoreboard(prediction);
    }
</script>