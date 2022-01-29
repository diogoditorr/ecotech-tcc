const { resolve, parse } = require("path");
const { defineConfig} = require("vite");
const fs = require("fs");

// Configuration for vite
const config = {
    path: {
        name: "./public/scripts",
        depth: 1,
    },
    extensions: [".ts"],
};

// Find all files with .js extension in a directory and return an array of file paths
function getFiles(dir, extensions = [".js"], depth = 1) {
    return fs
        .readdirSync(dir, { withFileTypes: true })
        .reduce((files, file) => {
            if (
                !file.isDirectory() &&
                !inArray(extensions, parse(file.name).ext)
            )
                return files;

            const name = dir + "/" + file.name;

            if (file.isDirectory() && depth > 1)
                return [...files, ...getFiles(name, extensions, depth - 1)];
            else if (!file.isDirectory()) return [...files, name];
            else return files;
        }, []);
}

function inArray(array, element) {
    return array.indexOf(element) > -1;
}

const entryPoints = {};
getFiles(config.path.name, config.extensions, config.path.depth).map((file) => {
    const fileObject = parse(file);
    entryPoints[fileObject.name] = resolve(__dirname, file);
});

module.exports = defineConfig({
    publicDir: false,
    build: {
        rollupOptions: {
            input: entryPoints,
            output: {
                entryFileNames: "assets/[name].js",
                sourcemap: true,
                compact: true,
            },
        },
    },
});
