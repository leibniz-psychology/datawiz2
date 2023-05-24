import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";

Dropzone.options.datawizDropzone = {
    createImageThumbnails: false,

    init: function () {
        this.on("sending", function (file, xhr, formData) {
            formData.append("originalFilename", file.name);
            // require templates/components/_infoBridge.html.twig -> experiment.id as value
            formData.append(
                "studyId",
                document.getElementById("infobridge").innerHTML.trim()
            );
        });

        this.on("success", function (file, responseText) {
            if (
                responseText["flySystem"] &&
                responseText["flySystem"][0]["fileType"] === "csv"
            ) {
                handleCSVFile(file, responseText);
            } else if (
                responseText["flySystem"] &&
                responseText["flySystem"][0]["fileType"] === "sav"
            ) {
                handleSAVFile(file, responseText);
            } else {
                location.reload();
            }
        });

    },
};

function handleCSVFile(file, responseText) {
    const modal = document.querySelector("#modal-dataset-import");
    const backdrop = document.querySelector(
        "#modal-dataset-import-backdrop"
    );
    const submitBtn = document.querySelector("#dataset-import-submit");
    const cancelBtn = document.querySelector("#dataset-import-cancel");
    const form = document.querySelector("#dataset-import-form");

    if (form === undefined) {
        return;
    }

    const previewUrl =
        this.element
            .getAttribute("data-preview-csv")
            .trim()
            .replace("%20", "") +
        encodeURI(responseText["flySystem"][0]["fileId"]);
    const submitUrl =
        this.element
            .getAttribute("data-submit-csv")
            .trim()
            .replace("%20", "") +
        encodeURI(responseText["flySystem"][0]["fileId"]);

    document.querySelector("#dataset-file-id").value =
        responseText["flySystem"][0]["fileId"];
    modal.classList.toggle("hidden");
    backdrop.classList.toggle("hidden");
    modal.classList.toggle("flex");
    backdrop.classList.toggle("flex");
    submitBtn.addEventListener("click", function () {
        POST(submitUrl, form, false, true);
    });
    cancelBtn.addEventListener("click", function () {
        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "dataset-import-remove");
        input.setAttribute("value", "true");
        form.append(input);
        console.log(form);
        POST(submitUrl, form, false, true);
    });
    const input = form.querySelectorAll(
        'select, input:not([type="hidden"])'
    );
    input.forEach((e) => {
        e.addEventListener("change", function () {
            POST(previewUrl, form, true, false);
        });
    });
    POST(previewUrl, form, true, false);
}

function handleSAVFile(file, responseText) {
    const previewSavUrl =
        this.element
            .getAttribute("data-preview-sav")
            .trim()
            .replace("%20", "") +
        encodeURI(responseText["flySystem"][0]["fileId"]);
    const submitSavUrl =
        this.element
            .getAttribute("data-submit-sav")
            .trim()
            .replace("%20", "") +
        encodeURI(responseText["flySystem"][0]["fileId"]);
    //GET(previewSavUrl, this.element, submitSavUrl);
    POST(submitSavUrl, this.element, false, true);
}

function POST(url, form, importPreview = false, reloadPage = false) {
    fetch(url, {
        method: "POST",
        body: new FormData(form),
    })
        .then(function (response) {
            if (response.ok) return response.json();
            else throw new Error("Hell no! What happened?");
        })
        .then((data) => {
            if (importPreview === true) {
                Alpine.store("import").codebook = data;
            }
            if (reloadPage) {
                location.reload();
            }
        })
        .catch((error) => {
            console.log(error);
        });
}

function GET(url, form, submitUrl) {
    fetch(url, {
        method: "GET",
    })
        .then(function (response) {
            if (response.ok) return response.json();
            else throw new Error("Hell no! What happened?");
        })
        .then((data) => {
            form.querySelector("#dataset-import-data").value = JSON.stringify(data);
            POST(submitUrl, form);
        })
        .catch((error) => {
            console.log(error);
        });
}
