/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single Style file (app.Style in this case)
import "tailwindcss/tailwind.css";
import "../Styles/app.scss";

import "dropzone/dist/dropzone.css";

import a2lix_lib from "@a2lix/symfony-collection/src/a2lix_sf_collection";
import Dropzone from "dropzone";

import "./alpine";
import "./detectStickyElements";
import "./collection-widget";

/*a2lix_lib.sfCollection.init({
	lang: {
		add: '',
		remove: 'Remove'
	}
});*/

Dropzone.options.datawizDropzone = {
  createImageThumbnails: false,
  init: function () {
    this.on("sending", function (file, xhr, formData) {
      formData.append("originalFilename", file.name);
      // require Templates/Components/_infoBridge.html.twig -> experiment.id as value
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
        const modal = document.querySelector("#modal-dataset-import");
        const backdrop = document.querySelector(
          "#modal-dataset-import-backdrop"
        );
        const submitBtn = document.querySelector("#dataset-import-submit");
        const form = document.querySelector("#dataset-import-form");
        if (form !== undefined) {
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
            POST(submitUrl, form);
            location.reload();
          });
          const input = form.querySelectorAll(
            'select, input:not([type="hidden"])'
          );
          input.forEach((e) => {
            e.addEventListener("change", function () {
              POST(previewUrl, form, "#dataset-import-result");
            });
          });
        }
      } else if (
        responseText["flySystem"] &&
        responseText["flySystem"][0]["fileType"] === "sav"
      ) {
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
        GET(previewSavUrl, this.element, submitSavUrl);
        location.reload();
      } else {
        location.reload();
      }
    });
  },
};

function POST(url, form, resultDiv = null) {
  fetch(url, {
    method: "POST",
    body: new FormData(form),
  })
    .then(function (response) {
      if (response.ok) return response.json();
      else throw new Error("Hell no! What happened?");
    })
    .then((data) => {
      if (resultDiv != null) {
        document.querySelector(resultDiv).innerHTML = JSON.stringify(data);
      }
      console.log(data);
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
      console.log(data);
      form.querySelector("#dataset-import-data").value = JSON.stringify(data);
      POST(submitUrl, form);
    })
    .catch((error) => {
      console.log(error);
    });
}

// console.log("Hello Webpack Encore! Edit me in Assets/Scripts/app.js"
