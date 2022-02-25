import { resolve, parse } from "path";
import { defineConfig } from "vite";
import { readdirSync } from "fs";

// Configuration for vite
const config = {
    path: {
        name: "./public/scripts",
        depth: 1,
    },
    extensions: [".ts"],
};

// Find all files with .js extension in a directory and return an array of file paths
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

const entryPoints: {
    [key: string]: string;
} = {};
getFiles(config.path.name, config.extensions, config.path.depth).map(
    (filePath: string) => {
        const file = parse(filePath);
        entryPoints[file.name] = resolve(__dirname, filePath);
    }
);

export default defineConfig({
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
