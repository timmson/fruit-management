const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const outputDir = path.resolve(__dirname, "../web/");

module.exports = {
    entry: "./src/index.tsx",
    output: {
        path: outputDir,
        filename: "./js/index.js"
    },
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /(node_modules)/,
                loader: "babel-loader",
                options: {
                    presets: ["@babel/preset-env", "@babel/preset-react"]
                }
            },
            {
                test: /\.tsx?$/,
                exclude: /(node_modules)/,
                loader: "ts-loader",
            },
            {
                test: /\.(sa|sc|c)ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "sass-loader"
                ]
            }
        ]
    },
    resolve: {
        extensions: [".tsx", ".ts", ".js"],
    },
    plugins: [
        new MiniCssExtractPlugin({filename: "./css/index.css"})
    ],
    devServer: {
        static: {
            directory: outputDir,
        },
        compress: true,
        port: 3000
    }
};