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

a2lix_lib.sfCollection.init();

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
      let modal = document.querySelector("#modal-dataset-import");
      let backdrop = document.querySelector("#modal-dataset-import-backdrop");
      let submitBtn = document.querySelector("#dataset-import-submit");
      // TODO error handling if fileID is not set and implement it in a more elegant way :-D
      document.querySelector("#dataset-file-id").value = responseText['flySystem'][0]['fileId'];
      modal.classList.toggle("hidden");
      backdrop.classList.toggle("hidden");
      modal.classList.toggle("flex");
      backdrop.classList.toggle("flex");
      submitBtn.addEventListener("click", function (event) {
        let form = document.querySelector("#dataset-import-form");
        let url = form.getAttribute('data-url').trim().replace('%20', '') + responseText['flySystem'][0]['fileId'];
        fetch(url, {
          method: 'POST',
          body: new FormData(form)
        }).then(function (response) {
          if (response.ok)
            return response.json();
          else
            throw new Error('Hell no! What happened?');
        }).then((data) => {
          console.log(data)
        }).catch(error => {
          console.log(error)
        });
      });
    });
  },
};

// console.log("Hello Webpack Encore! Edit me in Assets/Scripts/app.js"
