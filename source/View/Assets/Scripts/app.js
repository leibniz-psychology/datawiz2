/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single Style file (app.Style in this case)
import "../Styles/tailwind-base.scss";
import "../Styles/app-base.scss";
import "../Styles/tailwind-components.scss";
import "../Styles/app-components.scss";
import "../Styles/tailwind-utilities.scss";
import "../Styles/app-utilities.scss";
import "dropzone/dist/dropzone.css"

import a2lix_lib from "@a2lix/symfony-collection/src/a2lix_sf_collection";
import dropzone from 'dropzone'

a2lix_lib.sfCollection.init();

import "./alpine";

// console.log("Hello Webpack Encore! Edit me in Assets/Scripts/app.js");
