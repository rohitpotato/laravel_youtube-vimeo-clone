{

	module: {

		noParse: [

			/node_modules[\\/]video\.js/
		]
	}

	module.exports = [
  {
    module: {
      rules: [
        {
          test: /\.(eot|svg|ttf|woff|woff2)$/,
          loader: 'url-loader',
        },
        {
          test: /\.scss$/,
          use: extractSass.extract({
            fallback: 'style-loader',
            use: [
              { loader: 'css-loader' },
              { loader: 'sass-loader' },
            ],
          }),
        },
      ],
    },
  },
];
}