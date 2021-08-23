module.exports = function (grunt) {
	'use strict';

	// Force use of Unix newlines
	grunt.util.linefeed = '\n';

	// Project configuration.
	grunt.initConfig({
		'dart-sass': {
			target: {
				options: {
					outputStyle: 'compressed'
				},
				files: {
					'styles/blocks.css': 'scss/blocks.scss',
					'../Plugins/RemoteData/Assets/remote-data.css': '../Plugins/RemoteData/Assets/remote-data.scss',
					'../Plugins/LocalData/Assets/local-data.css': '../Plugins/LocalData/Assets/local-data.scss',
				}
			}
		}
	});

	// These plugins provide necessary tasks.
	require('load-grunt-tasks')(grunt);
	require('time-grunt')(grunt);

	grunt.registerTask('default', ['dart-sass']);
};
