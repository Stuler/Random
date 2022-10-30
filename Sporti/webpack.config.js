const path = require('path');

module.exports = {
	ignoreWarnings: [
		{
			module: /materialize.scss/gm, // A RegExp
		},
		{
			module : /materialize.scss/gm,
			message: /homepage/,
		},
		/warning from compiler/,
		(warning) => true,
	],
	mode          : (process.env.NODE_ENV === 'production') ? 'production' : 'development',
	resolve       : {
		extensions: [".js", ".json"],
	},
	resolveLoader : {
		modules: [
			'node_modules',
		]
	},
	output        : {
		filename  : 'bundle.js',
		path      : __dirname + "/www/assets",
		publicPath: "/assets/",
	},
	devServer     : {
		static  : {
			directory: path.join(__dirname, '/www/assets'),
		},
		compress: true,
		port    : 8080,
	},
	module        : {
		rules: [
			{
				test: /\.(jpe?g|png|gif|webp|eot|ttf|woff|woff2|svg|)$/i,
				use : [
					{loader: 'url-loader', options: {limit: 1000, name: 'assets/[name].[ext]'}} // assets/[name]-[hash].[ext] // přidá na konec názvu hash, Není pak nutné invalidovat obrázky
				]
			},
			{
				test   : /\.js$/,
				exclude: /node_modules/,
				loader : "babel-loader",
			},
			{
				test: /\.(sass|css|scss)$/,
				use : [
					'style-loader',
					'css-loader',
					'sass-loader',
				]
			},
		]
	},
}