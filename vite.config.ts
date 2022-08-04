import { parse } from "path";
import { defineConfig } from "vite";
import { readdirSync } from "fs";

// Configuration for vite
const config = {
    directories: [
        {
            name: "./resources/scripts",
            depth: 1,
            extensions: [".ts"],
        },
        {
            name: "./resources/sass",
            depth: 3,
            extensions: [".scss"],
        },
    ],
};

function getFiles(
    dir: string,
    extensions: Array<string> = [".js"],
    depth: number = 1
): string[] | [] {
    return readdirSync(dir, { withFileTypes: true }).reduce(
        (files: string[] | [], file) => {
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
        },
        []
    );
}

function inArray(array: Array<any>, element: any) {
    return array.indexOf(element) > -1;
}

const entryPoints: string[] = [];
config.directories.forEach((directory) => {
    const files = getFiles(
        directory.name,
        directory.extensions,
        directory.depth
    );
    files.forEach((filePath) => {
        entryPoints.push(filePath);
    });
});

console.log(entryPoints);

export default defineConfig({
    publicDir: false,
    build: {
        rollupOptions: {
            input: entryPoints,
            output: {
                entryFileNames: "assets/[name].js",
                assetFileNames: "assets/[name][extname]",
                sourcemap: true,
                compact: true,
            },
        },
    },
});
