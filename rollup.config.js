// rollup.config.js
import resolve from 'rollup-plugin-node-resolve';
import babel from 'rollup-plugin-babel';
import uglify from 'rollup-plugin-uglify';
import { minify } from 'uglify-es';

let dir = 'public/source/js/';

const testFolder = './public/source/dev-js/';
const fs = require('fs');

let moduleNames = {
	'stripe.js': 'WilokeSubmissionPayWithStripe',
	'2checkout.js': 'WilokeSubmissionPayWithTwocheckout'
};

let aConfiguration = [];

fs.readdirSync(testFolder).forEach(file => {
	aConfiguration.push(
		{
			input: testFolder+file,
			output: {
				file: dir+file,
				format: 'iife',
				name: typeof moduleNames[file] !== 'undefined' ? moduleNames[file] : 'Wiloke_'+Date.now(),
			},
			plugins: [
				resolve(),
				uglify({}, minify),
				babel({
					exclude: 'node_modules/**' // only transpile our source code
				})
			]
		}
	);
});

export default aConfiguration;