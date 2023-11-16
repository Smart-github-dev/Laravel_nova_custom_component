let mix = require("laravel-mix");

require("./nova.mix");

mix.setPublicPath("dist")
    .js("resources/js/flow.js", "js")
    .vue({ version: 3 })
    .css("resources/css/flow.css", "css")
    .nova("acme/flow-editor");
